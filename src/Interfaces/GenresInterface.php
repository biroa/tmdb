<?php
/**
 * This file is part of the Tmdb package.
 *
 * (c) Vincent Faliès <vincent.falies@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *

 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */


namespace vfalies\tmdb\Interfaces;

/**
 * Interface for Genres type object
 * @author Vincent Faliès <vincent.falies@gmail.com>
 * @copyright Copyright (c) 2017
 */
interface GenresInterface
{
    /**
     * TV genres list
     * @param array $options
     */
    public function getTVList(array $options = array());

    /**
     * Movie genres list
     * @param array $options
     */
    public function getMovieList(array $options = array());
}
