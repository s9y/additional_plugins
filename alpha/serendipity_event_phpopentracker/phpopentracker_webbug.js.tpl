{literal}
<script language="JavaScript" type="text/javascript">
  //
  // phpOpenTracker - The Website Traffic and Visitor Analysis Solution
  //
  // Copyright 2000 - 2005 Sebastian Bergmann. All rights reserved.
  //
  // Licensed under the Apache License, Version 2.0 (the "License");
  // you may not use this file except in compliance with the License.
  // You may obtain a copy of the License at
  //
  //   http://www.apache.org/licenses/LICENSE-2.0
  //
  // Unless required by applicable law or agreed to in writing, software
  // distributed under the License is distributed on an "AS IS" BASIS,
  // WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  // See the License for the specific language governing permissions and
  // limitations under the License.
  //

  var client_id = {/literal}{$client_id}{literal};

  // Taken from http://www.jan-winkler.de/hw/artikel/art_j02.htm

  function base64_encode(decStr) {
    var base64s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
    var bits;
    var dual;
    var i = 0;
    var encOut = '';

    while(decStr.length >= i + 3) {
      bits = (decStr.charCodeAt(i++) & 0xff) <<16 |
            (decStr.charCodeAt(i++) & 0xff) <<8 |
              decStr.charCodeAt(i++) & 0xff;

      encOut += base64s.charAt((bits & 0x00fc0000) >>18) +
                base64s.charAt((bits & 0x0003f000) >>12) +
                base64s.charAt((bits & 0x00000fc0) >> 6) +
                base64s.charAt((bits & 0x0000003f));
    }

    if(decStr.length -i > 0 && decStr.length -i < 3) {
      dual = Boolean(decStr.length -i -1);

      bits = ((decStr.charCodeAt(i++) & 0xff) <<16) |
            (dual ? (decStr.charCodeAt(i) & 0xff) <<8 : 0);

      encOut += base64s.charAt((bits & 0x00fc0000) >>18) +
                base64s.charAt((bits & 0x0003f000) >>12) +
                (dual ? base64s.charAt((bits & 0x00000fc0) >>6) : '=') +
                '=';
    }

    return(encOut);
  }

  var resolution = window.screen.width + 'x' +
                  window.screen.height + 'x' +
                  window.screen.colorDepth + 'bit';

  document.write(
    '<img src="{/literal}{$webbugimageurl}{literal}?' +
    'client_id='              + {/literal}{$client_id}{literal} + '&' +
    'document_url='           + base64_encode(document.URL) + '&' +
    'referer='                + base64_encode(document.referrer) + '&' +
    'add_data[]=resolution::' + resolution +
    '" alt="" width="1" height="1" />'
  );

</script>
<noscript>
  <img alt="" src="{/literal}{$webbugimageurl}{literal}?client_id={/literal}{$client_id}{literal}" width="1" height="1" />
</noscript>
{/literal}