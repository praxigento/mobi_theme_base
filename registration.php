<?php
/**
 * Script to register M2-module
 *
 * Dmitrii Makhov <dmitriimakhov@gmail.com>
 */

use Magento\Framework\Component\ComponentRegistrar as Registrar;
use Praxigento\ThemeBase\Config as Config;

Registrar::register(Registrar::THEME, Config::THEME, __DIR__);
Registrar::register(Registrar::MODULE, Config::MODULE, __DIR__);
