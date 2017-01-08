<?php
/**
 * Copyright (c) 2015 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the LICENSE file distributed with this package.
 *
 *
 * @category   WURFL
 *
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 */

namespace UaNormalizer\Specific;

use UaNormalizer\Helper\Android as AndroidHelper;
use UaNormalizer\Helper\OperaMobiOrTabletOnAndroid as OperaMobiOrTabletOnAndroidHelper;
use UaNormalizer\NormalizerInterface;

/**
 * User Agent Normalizer
 */
class OperaMobiOrTabletOnAndroid implements NormalizerInterface
{
    /**
     * @param string $userAgent
     *
     * @return string
     */
    public function normalize($userAgent)
    {
        $s = \Stringy\create($userAgent);

        $isOperaMobile = $s->contains('Opera Mobi');
        $isOperaTablet = $s->contains('Opera Tablet');

        if ($isOperaMobile || $isOperaTablet) {
            $operaVersion   = OperaMobiOrTabletOnAndroidHelper::getOperaOnAndroidVersion($userAgent, false);
            $androidVersion = AndroidHelper::getAndroidVersion($userAgent, false);

            if ($operaVersion !== null && $androidVersion !== null) {
                $operaModel = $isOperaTablet ? 'Opera Tablet' : 'Opera Mobi';
                $prefix     = $operaModel . ' ' . $operaVersion . ' Android ' . $androidVersion . '---';

                return $prefix . $userAgent;
            }
        }

        return $userAgent;
    }
}
