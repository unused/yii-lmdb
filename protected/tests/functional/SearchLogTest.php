<?php

class SearchLogTest extends WebTestCase
{
	public $fixtures=array(
		'searchLogs'=>'SearchLog',
	);

	public function testShow()
	{
		$this->open('?r=searchLog/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=searchLog/create');
	}

	public function testUpdate()
	{
		$this->open('?r=searchLog/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=searchLog/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=searchLog/index');
	}

	public function testAdmin()
	{
		$this->open('?r=searchLog/admin');
	}
}
