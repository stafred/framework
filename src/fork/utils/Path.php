<?php

namespace Stafred\Utils {
    /**
     * Class DirAbstract
     * @package Stafred\Utils
     */
    abstract class PathAbstract {
        /**
         * @var string
         */
        protected string $path = '';
        /**
         * @var string
         */
        protected int $level = 6;
        /**
         * @param string $dir
         * @param int $level
         * @return string
         */
        protected function get(string $dir, int $level)
        {
            return Str::reverseSlash(dirname($this->path, $level)) . '/' . $dir;
        }
    }

    /**
     * Class DirAbstract
     * @package Stafred\Utils
     */
    abstract class DirRootAbstract extends PathAbstract
    {
        abstract public function app();

        abstract public function async();

        abstract public function bin();

        abstract public function factory();

        abstract public function public();

        abstract public function vendor();
    }

    /**
     * Class DirAbstract
     * @package Stafred\Utils
     */
    abstract class DirEtcAbstract extends PathAbstract
    {
        abstract public function log();

        abstract public function session();

        abstract public function storage();
    }
    
    /**
     * Class Dir
     * @package Stafred\Utils
     */
    final class Path
    {
        /**
         * @var string
         */
        private string $path = '';
        /**
         * @var string
         */
        private int $level = 6;

        /**
         * Path constructor.
         * @param int $level
         */
        public function __construct(int $level = 6)
        {
            $this->path = __DIR__;
            $this->level = $level;
        }

        /**
         * @return DirRootAbstract
         */
        public function root(): DirRootAbstract
        {
            return new class($this->path, $this->level) extends DirRootAbstract
            {
                /**
                 *  constructor.
                 * @param string $path
                 * @param int $level
                 */
                public function __construct(string $path, int $level)
                {
                    $this->path = $path;
                    $this->level = $level;
                }

                /**
                 * @return string
                 */
                public function app(){
                    return $this->get(__FUNCTION__, $this->level);
                }

                /**
                 * @return string
                 */
                public function async(){
                    return $this->get(__FUNCTION__, $this->level);
                }

                /**
                 * @return string
                 */
                public function bin(){
                    return $this->get(__FUNCTION__, $this->level);
                }

                /**
                 * @return string
                 */
                public function factory(){
                    return $this->get(__FUNCTION__, $this->level);
                }

                /**
                 * @return string
                 */
                public function public(){
                    return $this->get(__FUNCTION__, $this->level);
                }

                /**
                 * @return string
                 */
                public function vendor(){
                    return $this->get(__FUNCTION__, 6);
                }
            };
        }

        /**
         * @return DirEtcAbstract
         */
        public function etc(): DirEtcAbstract
        {
            return new class($this) extends DirEtcAbstract
            {
                /**
                 * @var Path
                 */
                protected Path $root;

                /**
                 *  constructor.
                 * @param string $path
                 * @param DirRootAbstract $root
                 */
                public function __construct(Path $root)
                {
                    $this->root = $root;
                }

                /**
                 * @return string
                 */
                public function log(){
                    return $this->root->root()->factory() . "/" . __FUNCTION__;
                }

                /**
                 * @return string
                 */
                public function session(){
                    return $this->root->root()->factory() . "/" . __FUNCTION__;
                }

                /**
                 * @return string
                 */
                public function storage(){
                    return $this->root->root()->factory() . "/" . __FUNCTION__;
                }
            };
        }
    }
}

