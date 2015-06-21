<?php

/**
 * Copyright (c) 2015-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   FactFinder/ComposerFacts
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-factfinder
 */

namespace GanbaroDigital\FactFinder\ComposerFacts\ComposerJsonFile;

use GanbaroDigital\FactFinder\Core\Data;
use GanbaroDigital\FactFinder\Core\Fact;
use GanbaroDigital\FactFinder\Core\FactBuilderFromData;
use GanbaroDigital\FactFinder\Core\FactBuilderFromFacts;
use GanbaroDigital\FactFinder\Core\FactBuilderQueue;
use GanbaroDigital\FactFinder\Core\FactRepository;

use GanbaroDigital\FactFinder\ComposerFacts;

class FactBuilder implements FactBuilderFromData, FactBuilderFromFacts
{
	/**
	 * return a list of the facts that we are interested in exploring
	 *
	 * @return array<string>
	 */
	static public function getInterestsList()
	{
		return [
			ComposerFacts\Facts\ComposerProjectFact::class
		];
	}

	public function buildFactsFromData(Data $data)
	{
		switch (get_class($fact)) {
			case FilesystemData::class:
				// create our new fact
				$composerJsonFileFact = FactBuilders\ComposerJsonFileFactBuilder::fromFilesystemData($data);

				// now, run our collection of fact builders to exact more
				// meaning from this fact's raw data
				FactBuilders\AutoloadPsr0FactBuilder::fromComposerJsonFileFact($composerJsonFileFact, $factBuilderQueue);
				FactBuilders\AutoloadPsr4FactBuilder::fromComposerJsonFileFact($composerJsonFileFact, $factBuilderQueue);

				// all done
				return [ $composerJsonFileFact ];
				break;
		}
	}

	public function buildFactsFromFact(Fact $fact)
	{
		return [];
	}
}