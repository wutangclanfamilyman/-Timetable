<?php

include 'php/Auth.class.php';
include 'php/AjaxRequest.class.php';

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();

class AuthorizationAjaxRequest extends AjaxRequest
{
    public $actions = array(
        "login" => "login",
        "logout" => "logout",
        "register" => "register",
    );

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }
        setcookie("sid", "");

        $username = $this->getRequestParam("loginInputEmail");
        $password = $this->getRequestParam("loginInputPassword");
        $remember = !!$this->getRequestParam("remember-me");

        if (empty($username)) {
            $this->setFieldError("loginInputEmail", "Enter the username");
            return;
        }

        if (empty($password)) {
            $this->setFieldError("loginInputPassword", "Enter the password");
            return;
        }

        $user = new Auth\User();
        $auth_result = $user->authorize($username, $password, $remember);

        if (!$auth_result) {
            $this->setFieldError("loginInputPassword", "Invalid username or password");
            return;
        }

        $this->status = "ok";
        $this->setResponse("redirect", ".");
        $this->message = sprintf("Hello, %s! Access granted.", $username);
    }

    public function logout()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }

        setcookie("sid", "");

        $user = new Auth\User();
        $user->logout();

        $this->setResponse("redirect", ".");
        $this->status = "ok";
    }

    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }

        setcookie("sid", "");

        $username = $this->getRequestParam("registerInputEmail");
        $password1 = $this->getRequestParam("registerInputPassword");
        $password2 = $this->getRequestParam("registerInputRepeatPassword");

        if (empty($username)) {
            $this->setFieldError("registerInputEmail", "Enter the username");
            return;
        }

        if (empty($password1)) {
            $this->setFieldError("registerInputPassword", "Enter the password");
            return;
        }

        if (empty($password2)) {
            $this->setFieldError("registerInputRepeatPassword", "Confirm the password");
            return;
        }

        if ($password1 !== $password2) {
            $this->setFieldError("registerInputRepeatPassword", "Confirm password is not match");
            return;
        }

        $user = new Auth\User();

        try {
            $new_user_id = $user->create($username, $password1);
        } catch (\Exception $e) {
            $this->setFieldError("registerInputPassword", $e->getMessage());
            return;
        }
        $user->authorize($username, $password1);

        $this->message = sprintf("Hello, %s! Thank you for registration.", $username);
        $this->setResponse("redirect", "/");
        $this->status = "ok";
    }
}

$ajaxRequest = new AuthorizationAjaxRequest($_REQUEST);
$ajaxRequest->showResponse();
