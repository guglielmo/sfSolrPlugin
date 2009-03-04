<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.cleata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    sfSolrPlugin
 * @subpackage Config
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfSolrModuleConfigHandler extends sfYamlConfigHandler
{
  public function execute($config)
  {
    $retval = "<?php\n".
                "// auto-generated by " . __CLASS__ . "\n".
                "// date: %s\n\n";
    $retval = sprintf($retval, date('Y/m/d H:i:s'));

    $config = $this->parseYamls($config);

    $retconfig = array();

    foreach ($config as $index => $mconfig)
    {
      $retconfig[$index] = array();

      foreach ($mconfig as $action => $config)
      {
        if (!isset($config['security']))
        {
          $retconfig[$index][$action]['security'] = array();
        }

        if (!isset($config['security']['authenticated']))
        {
          $retconfig[$index][$action]['security']['authenticated'] = false;
        }

        if (!isset($config['security']['credentials']))
        {
          $retconfig[$index][$action]['security']['credentials'] = array();
        }

        if (!isset($config['params']))
        {
          $retconfig[$index][$action]['params'] = array();
        }

        if (!isset($config['layout']))
        {
          $retconfig[$index][$action]['layout'] = false;
        }
      }
    }

    $retval .= sprintf("\$actions = %s;", var_export($retconfig, true));

    return $retval;
  }
}