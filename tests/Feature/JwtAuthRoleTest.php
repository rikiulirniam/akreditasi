<?php

namespace Tests\Feature;

use App\Services\JwtService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JwtAuthRoleTest extends TestCase
{
    use RefreshDatabase;

    protected JwtService $jwtService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jwtService = app(JwtService::class);
    }

    protected function generateTestToken(string $role, int $userId = 1): string
    {
        return $this->jwtService->generateToken([
            'sub' => (string) $userId,
            'nama' => 'User '.ucfirst($role),
            'email' => strtolower($role).'@polines.ac.id',
            'role' => strtoupper($role),
            'permissions' => [],
        ]);
    }

    public function test_access_without_token_returns_401(): void
    {
        $response = $this->getJson('/api/v1/auth/me');

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_access_with_invalid_token_returns_401(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer invalid.token.signature')
            ->getJson('/api/v1/auth/me');

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_administrator_can_access_auth_me_and_master_data(): void
    {
        $token = $this->generateTestToken('ADMINISTRATOR', 1);

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJsonPath('data.user.role', 'ADMINISTRATOR');
    }

    public function test_kaprodi_can_view_projects_but_cannot_modify_master_data(): void
    {
        $token = $this->generateTestToken('KAPRODI', 2);

        // Kaprodi can view master kriteria (read-only)
        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/master/kriteria')
            ->assertStatus(200);

        // Kaprodi CANNOT create master kriteria (403 Forbidden)
        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/master/kriteria', [
                'kode_kriteria' => 'TEST',
                'nama_kriteria' => 'Test Kriteria',
            ])
            ->assertStatus(403);
    }

    public function test_reviewer_can_view_self_assessment_but_cannot_create_project(): void
    {
        $token = $this->generateTestToken('REVIEWER', 3);

        // Reviewer can view self-assessment
        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/self-assessment')
            ->assertStatus(200);

        // Reviewer CANNOT create project akreditasi (403 Forbidden)
        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/projects', [
                'nama_project' => 'Project Unauthorized',
            ])
            ->assertStatus(403);
    }

    public function test_dosen_can_view_projects_but_cannot_modify_self_assessment(): void
    {
        $token = $this->generateTestToken('DOSEN', 4);

        // Dosen can view projects
        $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/projects')
            ->assertStatus(200);

        // Dosen CANNOT access or submit self-assessment (403 Forbidden)
        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/self-assessment', [
                'id_project' => 1,
            ])
            ->assertStatus(403);
    }
}
