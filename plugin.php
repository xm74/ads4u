<?php

class pluginAds4U extends Plugin {

        private $enable;

        private function ads4u()
        {
                $ret  = '<!-- Ads4U BEGIN -->'.PHP_EOL;
                $ret .= '	'.Sanitize::htmlDecode($this->getValue('ads4uCode')).PHP_EOL;
                $ret .= '<!-- Ads4U END -->'.PHP_EOL;

                return $ret;
        }

        public function init()
        {
                $this->dbFields = array(
                        'enablePages'=>false,
                        'enablePosts'=>false,
                        'ads4uCode'=>''
                );
        }

        public function form()
        {
                global $Language;

                $html  = '<div>';
                $html .= '<label for="ads4uenablepages">'.$Language->get('enable-ads4u-on-pages').'</label>';
                $html .= '<select id="ads4uenablepages" name="enablePages">';
                $html .= '<option value="true" '.($this->getValue('enablePages')===true?'selected':'').'>'.$Language->get('enabled').'</option>';
                $html .= '<option value="false" '.($this->getValue('enablePages')===false?'selected':'').'>'.$Language->get('disabled').'</option>';
                $html .= '</select>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<label for="ads4uenableposts">'.$Language->get('enable-ads4u-on-posts').'</label>';
                $html .= '<select id="ads4uenableposts" name="enablePosts">';
                $html .= '<option value="true" '.($this->getValue('enablePosts')===true?'selected':'').'>'.$Language->get('enabled').'</option>';
                $html .= '<option value="false" '.($this->getValue('enablePosts')===false?'selected':'').'>'.$Language->get('disabled').'</option>';
                $html .= '</select>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<label for="ads4ucode">'.$Language->get('ads4u-html-code').'</label>';
                $html .= '<textarea id="ads4ucode" type="text" name="ads4uCode">'.$this->getValue('ads4uCode').'</textarea>';
                $html .= '<span class="tip">'.$Language->get('complete-this-field-with-html-code').'</span>';
                $html .= '</div>';

                return $html;
        }

        public function pageEnd()
        {
                global $url, $page;

                if( $this->getValue('ads4uCode') != '' ) {
                        if( $url->whereAmI()=='page' ) {
                                if( ($this->getValue('enablePosts') && $page->published()) ||
                                    ($this->getValue('enablePages') && $page->static()) ) {
                                        return $this->ads4u();
                                }
                        }
                }
                return false;
        }

}
