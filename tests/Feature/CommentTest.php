<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * Test Get comments
     *
     * @return void
     */
    public function testGetComments()
    {
        $response = $this->get('/api/comments');

        $response->assertStatus(200);
    }

    /**
     * Test Create comments
     *
     * @return void
     */
    public function testCreateComment()
    {
        $response = $this->post('/api/comment',[
            'name' => 'test name',
            'comment' => 'test comment',
        ]);
        $response->assertStatus(201);
    }
    /**
     * Test Create comments with parent id
     *
     * @return void
     */
    public function testCreateCommentWithParentId()
    {
        $response = $this->post('/api/comment',[
            'name' => 'test name',
            'comment' => 'test comment',
            'comment_parent_id' => 1,
        ]);
        $response->assertStatus(201);
    }
    /**
     * Test Create comments with no name
     *
     * @return void
     */
    public function testCreateCommentWithNoName()
    {
        $response = $this->json('POST', '/api/comment',[
            'name'=>'',
            'comment' => 'test comment',
        ]);
        $errorMessage = json_decode($response->getContent(),true);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' => [
                    'The name field is required.'
                ]
            ]
        ]);
        $response->assertStatus(422);

    }
    /**
     * Test Create comments with no comment
     *
     * @return void
     */
    public function testCreateCommentWithNoComment()
    {
        $response = $this->json('POST', '/api/comment',[
            'name'=>'test 1',
        ]);
        $errorMessage = json_decode($response->getContent(),true);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'comment' => [
                    'The comment field is required.'
                ]
            ]
        ]);
        $response->assertStatus(422);

    }
}
