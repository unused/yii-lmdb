<?php

class SiteTest extends WebTestCase
{
  public function testLogin(){
    $this->open('login.html');
    $this->assertElementPresent('name=LoginForm[username]');
    $this->assertElementPresent('name=LoginForm[password]');

    $this->clickAndWait('name=yt0');
    $this->assertTextPresent('Username cannot be blank.');
    $this->assertElementPresent('name=LoginForm[username]');
    $this->assertTextPresent('Password cannot be blank.');
    $this->assertElementPresent('name=LoginForm[password]');

    $this->type('name=LoginForm[username]','admin');
    $this->clickAndWait('name=yt0');
    $this->assertTextNotPresent('Username cannot be blank.');
    $this->assertElementPresent('name=LoginForm[username]');
    $this->assertTextPresent('Password cannot be blank.');
    $this->assertElementPresent('name=LoginForm[password]');
  }

//   public function testIndex()
//   {
//     $this->open('');
//     if($this->isTextPresent('Logout'))
//       $this->clickAndWait('link=Logout');
//     $this->assertElementPresent('name=LoginForm[username]');
//     $this->assertElementPresent('name=LoginForm[password]');
//   }
//
//   public function testContact()
//   {
//     $this->open('?r=site/contact');
//     $this->assertTextPresent('Error 404');
//   }
//
// 	public function testLoginLogout()
// 	{
// 		$this->open('');
// 		// ensure the user is logged out
// 		if($this->isTextPresent('Logout'))
// 			$this->clickAndWait('link=Logout');
//
// 		// test login process, including validation
// 		$this->clickAndWait('button=Login');
// 		$this->assertElementPresent('name=LoginForm[username]');
// 		$this->type('name=LoginForm[username]','demo');
// 		$this->clickAndWait("//input[@value='Login']");
// 		$this->assertTextPresent('Password cannot be blank.');
// 		$this->type('name=LoginForm[password]','demo');
// 		$this->clickAndWait("//input[@value='Login']");
// 		$this->assertTextNotPresent('Password cannot be blank.');
// 		$this->assertTextPresent('Logout');
//
// 		// test logout process
// 		$this->assertTextNotPresent('Login');
// 		$this->clickAndWait('link=Logout');
// 		$this->assertTextPresent('Login');
// 	}
}
