<?php
//公共配置
$common_config = include APP_PATH.'../Conf/config.php';

//私有配置
$private_config = array(
                        'LAYOUT_ON' => true,
                        'URL_ROUTER_ON' => true,
                        'URL_CASE_INSENSITIVE' =>true,
                        'URL_ROUTE_RULES' => array(
                                                  'modprinter/:pid' => 'Printer/modprinter',
                                                  'delprinter/:pid' => 'Printer/delprinter',
                                                  'viewprinter/:pid' => 'Printer/viewprinter',
                                                  'downprinter/:pid/:deviceid/:hs' => 'Printer/downprinter',
                                                    'api/:token'        => 'Home/Weixin/index',
                                                  )
                        );

return array_merge($common_config, $private_config);
