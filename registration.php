<?php
/**
 * Script to register M2-module
 *
 */
use Magento\Framework\Component\ComponentRegistrar as Registrar;
use Praxigento\Mage2Theme\Config as Config;

Registrar::register(Registrar::THEME, Config::THEME, __DIR__);
Registrar::register(Registrar::MODULE, Config::MODULE, __DIR__);
