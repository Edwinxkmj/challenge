<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileFoodsTest extends TestCase
{
    public function testGetDetail()
    {
        $response = $this->get('/api/mobile-food/detail?id=934582');
        $response->assertStatus(200)->assertJsonPath('code', 0);

        $response = $this->get('/api/mobile-food/detail?id=fdsafdsafdsa');
        $response->assertStatus(200)->assertJsonPath('code', -102);
    }

    public function testAdd()
    {
        $response = $this->post('/api/mobile-food/add', [
            'address'     => 'test address',
            'cnn'         => '1111',
            'locationDescription' => 'test address location description',
            'zipCode'     => '',
            'expiredDate' => '2022-06-21 09:00:00',
            'applicant'   => 'test applicant',
        ]);

        $response->assertStatus(200)->assertJsonPath('code', 0);

        $response = $this->post('/api/mobile-food/add', [
            'address'     => 'test address',
            'cnn'         => '1111',
            'locationDescription' => 'test address location description',
            'zipCode'     => '',
            'expiredDate' => '2022-06-21 09:00:00',
        ]);

        $response->assertStatus(200)->assertJsonPath('code', -103);
    }

    public function testChangeAddress()
    {
        $response = $this->post('/api/mobile-food/change-address', [
            'address'     => 'test address',
            'id'          => 1527317
        ]);

        $response->assertStatus(200)->assertJsonPath('code', 0);

        $response = $this->post('/api/mobile-food/change-address', [
            'id'          => 1527317
        ]);
        $response->assertStatus(200)->assertJsonPath('code', -103);
    }

    public function testNearbyMobileFood()
    {
        $response = $this->get('/api/mobile-food/nearby?latitude=37.776736212750116&longitude=-122.41639493007732');

        $response->assertStatus(200)->assertJsonPath('code', 0);

        $response = $this->get('/api/mobile-food/nearby?latitude=67.776736212750116&longitude=-152.41639493007732');
        $response->assertStatus(200)->assertJsonPath('code', 0)->assertJsonCount(0, 'data');
    }
}
