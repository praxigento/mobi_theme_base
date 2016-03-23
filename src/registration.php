<?php
/**
 * Script to register M2-module
 *
 */
use Praxigento\Mage2theme\Config as Config;
use Magento\Framework\Component\ComponentRegistrar as Registrar;

Registrar::register(Registrar::MODULE, Config::MODULE, __DIR__);
