<?php

namespace my\Http\Actions;

use my\Http\Request;
use my\Http\Response;

interface ActionInterface
{
    public function handle(Request $request): Response;
}