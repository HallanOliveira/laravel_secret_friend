<?php

namespace App\Http\Controllers;

class AppBaseController extends Controller
{
    protected function redirectWithError(string $message, string $route) {
        $this->setFlashMessage($message, 'danger');
        return redirect()->route($route);
    }

    protected function redirectWithSuccess(string $message, string $route) {
        $this->setFlashMessage($message, 'success');
        return redirect()->route($route);
    }

    protected function setFlashMessage(string $message, string $class) {
        session()->flash('message', $message);
        session()->flash('class', $class);
    }
}
