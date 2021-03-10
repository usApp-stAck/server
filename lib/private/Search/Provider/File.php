<?php
/**
 * @copyright Copyright (c) 2016, ownCloud, Inc.
 *
 * @author Andrew Brown <andrew@casabrown.com>
 * @author Bart Visscher <bartv@thisnet.nl>
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @author Jakob Sack <mail@jakobsack.de>
 * @author Jörn Friedrich Dreyer <jfd@butonic.de>
 * @author Morris Jobke <hey@morrisjobke.de>
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OC\Search\Provider;

use OC\Files\Filesystem;
use OCP\Search\PagedProvider;

/**
 * Provide search results from the 'files' app
 */
class File extends PagedProvider {

	/**
	 * Search for files and folders matching the given query
	 *
	 * @param string $query
	 * @param int|null $limit
	 * @param int|null $offset
	 * @return \OCP\Search\Result[]
	 */
	public function search($query, int $limit = null, int $offset = null) {
		if ($offset === null) {
			$offset = 0;
		}
		\OC_Util::setupFS();
		$files = Filesystem::search($query);
		$results = [];
		if ($limit !== null) {
			$files = array_slice($files, $offset, $offset + $limit);
		}
		// edit results
		foreach ($files as $fileData) {
			// skip versions
			if (strpos($fileData['path'], '_versions') === 0) {
				continue;
			}
			// skip top-level folder
			if ($fileData['name'] === 'files' && $fileData['parent'] === -1) {
				continue;
			}
			// create audio result
			if ($fileData['mimepart'] === 'audio') {
				$result = new \OC\Search\Result\Audio($fileData);
			}
			// create image result
			elseif ($fileData['mimepart'] === 'image') {
				$result = new \OC\Search\Result\Image($fileData);
			}
			// create folder result
			elseif ($fileData['mimetype'] === 'httpd/unix-directory') {
				$result = new \OC\Search\Result\Folder($fileData);
			}
			// or create file result
			else {
				$result = new \OC\Search\Result\File($fileData);
			}
			// add to results
			$results[] = $result;
		}
		// return
		return $results;
	}

	public function searchPaged($query, $page, $size) {
		if ($size === 0) {
			return $this->search($query);
		} else {
			return $this->search($query, $size, ($page - 1) * $size);
		}
	}
}
