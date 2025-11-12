<?php

namespace Tests\Feature;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubjectCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_display_all_subjects()
    {
        $this->actingAs($this->user);

        Subject::factory()->count(3)->create();

        $response = $this->get(route('subjects.index'));

        $response->assertStatus(200);
        $response->assertViewIs('subjects.index');
        $response->assertViewHas('subjects');
    }

    /** @test */
    public function it_can_create_a_new_subject()
    {
        $this->actingAs($this->user);

        $subjectData = [
            'name_en' => 'Test Subject',
            'name_ar' => 'مادة اختبار',
            'description' => 'This is a test subject description',
        ];

        $response = $this->post(route('subjects.store'), $subjectData);

        $response->assertRedirect(route('subjects.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('subjects', [
            'name_en' => 'Test Subject',
            'name_ar' => 'مادة اختبار',
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_subject()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('subjects.store'), []);

        $response->assertSessionHasErrors(['name_en', 'name_ar']);
    }

    /** @test */
    public function it_can_display_a_single_subject()
    {
        $this->actingAs($this->user);

        $subject = Subject::factory()->create();

        $response = $this->get(route('subjects.show', $subject));

        $response->assertStatus(200);
        $response->assertViewIs('subjects.show');
        $response->assertViewHas('subject', $subject);
    }

    /** @test */
    public function it_can_update_an_existing_subject()
    {
        $this->actingAs($this->user);

        $subject = Subject::factory()->create();

        $updateData = [
            'name_en' => 'Updated Subject',
            'name_ar' => 'مادة محدثة',
            'description' => 'Updated description',
        ];

        $response = $this->put(route('subjects.update', $subject), $updateData);

        $response->assertRedirect(route('subjects.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('subjects', [
            'id' => $subject->id,
            'name_en' => 'Updated Subject',
            'name_ar' => 'مادة محدثة',
        ]);
    }

    /** @test */
    public function it_can_delete_a_subject()
    {
        $this->actingAs($this->user);

        $subject = Subject::factory()->create();

        $response = $this->delete(route('subjects.destroy', $subject));

        $response->assertRedirect(route('subjects.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('subjects', [
            'id' => $subject->id,
        ]);
    }

    /** @test */
    public function it_can_search_subjects()
    {
        $this->actingAs($this->user);

        $mathSubject = Subject::factory()->create([
            'name_en' => 'Mathematics',
            'name_ar' => 'الرياضيات',
        ]);

        $physicsSubject = Subject::factory()->create([
            'name_en' => 'Physics',
            'name_ar' => 'الفيزياء',
        ]);

        $response = $this->get(route('subjects.index', ['search' => 'Math']));

        $response->assertStatus(200);
        $response->assertSee('Mathematics');
        $response->assertDontSee('Physics');
    }

    /** @test */
    public function it_can_filter_subjects_by_fee_status()
    {
        // This test is no longer relevant since fee_amount has been removed
        // Subjects no longer have fee amounts, so filtering by fee status is not applicable
        $this->assertTrue(true); // Placeholder to keep test structure
    }

    /** @test */
    public function it_can_sort_subjects()
    {
        $this->actingAs($this->user);

        $subjectA = Subject::factory()->create([
            'name_en' => 'Biology',
        ]);

        $subjectB = Subject::factory()->create([
            'name_en' => 'Chemistry',
        ]);

        $response = $this->get(route('subjects.index', ['sort' => 'name_asc']));

        $response->assertStatus(200);
        $response->assertSeeInOrder(['Biology', 'Chemistry']);
    }
}
