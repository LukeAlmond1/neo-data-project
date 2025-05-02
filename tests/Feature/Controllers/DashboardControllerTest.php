<?php

namespace Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDashboardReturnsInertiaPageWithAnalysisData(): void
    {
        $response = $this->actingAsUser()->get(route('dashboard'));

        $response->assertInertia(
            fn (AssertableInertia $page) => $page
                ->component('dashboard')
                ->has('analysis.data', 1));

        $response->assertOk();
    }

    protected function actingAsUser()
    {
        $user = \App\Models\User::factory()->create();

        return $this->actingAs($user);
    }
}
