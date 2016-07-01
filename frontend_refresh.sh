#!/usr/bin/env bash

work/bin/magento deploy:mode:set developer
work/bin/magento indexer:reindex
work/bin/magento cache:disable
work/bin/magento cache:clean
work/bin/magento cache:flush
