<?php

namespace pronajem\base;

interface Middleware
{
    public function handle(): void;
}