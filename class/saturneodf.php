<?php

/* Copyright (C) 2022-2023 EVARISK <technique@evarisk.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    admin/about.php
 * \ingroup saturne
 * \brief   About page of module Saturne.
 */

// Load Saturne environment.
if (file_exists('../saturne.main.inc.php')) {
    require_once __DIR__ . '/../saturne.main.inc.php';
} elseif (file_exists('../../saturne.main.inc.php')) {
    require_once __DIR__ . '/../../saturne.main.inc.php';
} else {
    die('Include of saturne main fails');
}


require_once ODTPHP_PATH . 'odf.php';

class SaturneOdf extends Odf {
    /**
	 * Assign a template variable as a picture
	 *
	 * @param string $key name of the variable within the template
	 * @param string $value path to the picture
	 * @throws OdfException
	 * @return odf
	 */
	public function setImageWithFixSize($key, $value,$width,$height)
	{
		$filename = strtok(strrchr($value, '/'), '/.');
		$file = substr(strrchr($value, '/'), 1);
		$size = @getimagesize($value);
		if ($size === false) {
			throw new OdfException("Invalid image");
		}
//		list ($width, $height) = $size;
//		$width *= self::PIXEL_TO_CM;
//		$height *= self::PIXEL_TO_CM;
		$xml = <<<IMG
			<draw:frame draw:style-name="fr1" draw:name="$filename" text:anchor-type="aschar" svg:width="{$width}cm" svg:height="{$height}cm" draw:z-index="3"><draw:image xlink:href="Pictures/$file" xlink:type="simple" xlink:show="embed" xlink:actuate="onLoad"/></draw:frame>
IMG;
		$this->images[$value] = $file;
		$this->setVars($key, $xml, false);
		return $this;
	}
}
