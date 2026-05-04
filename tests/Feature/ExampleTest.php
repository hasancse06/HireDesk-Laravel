<?php

test('the home page redirects to the public job board', function () {
    $response = $this->get('/');

    $response->assertRedirect('/jobs');
});