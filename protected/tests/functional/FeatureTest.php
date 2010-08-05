<?php

class FeatureTest extends WebTestCase
{
	public $fixtures=array(
		'features'=>'Feature',
	);

	public function testShow()
	{
		$this->open('?r=feature/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=feature/create');
	}

	public function testUpdate()
	{
		$this->open('?r=feature/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=feature/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=feature/index');
	}

	public function testAdmin()
	{
		$this->open('?r=feature/admin');
	}
}
