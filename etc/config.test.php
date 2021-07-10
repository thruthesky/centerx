<?php

isTrue(config()->version == 1, "config version must be 1");
config()->version++;
isTrue(config()->version == 2, "config version must be 2");
