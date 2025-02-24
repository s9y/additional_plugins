<?php 

##########################################################################
# serendipity - another blogger...                                       #
##########################################################################
#                                                                        #
# (c) 2003 Jannis Hermanns <J@hacked.it>                                 #
# http://www.jannis.to/programming/serendipity.html                      #
#                                                                        #
##########################################################################

        $servicesdb = array(
            array(
              'name'       => 'Ping-o-Matic',
              'host'       => 'rpc.pingomatic.com',
              'path'       => '/',
              'extended'   => true,
              'supersedes' => array('blo.gs', 'blogrolling.com', 'technorati.com', 'weblogs.com', 'Yahoo!')
            ),

            array(
              'name'     => 'blo.gs',
              'host'     => 'ping.blo.gs',
              'path'     => '/',
              'extended' => true
            ),
                                                                  
        );
?>
