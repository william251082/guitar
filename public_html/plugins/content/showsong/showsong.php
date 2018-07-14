<?php
defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_guitar/models', 'GuitarModel');

class plgContentShowsong extends JPlugin
{
    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        // check if showrecipe tag exists in the content
        if (strpos($article->text, 'showsong') === false) {
            return true;
        }
        // Search for showsong tag in the content
        $regex = '/{showsong\s+(.*?)}/i';
        //each instance of the tag will be sent to the process function and
        // replaced with the song text
        $article->text = preg_replace_callback( $regex, array('self', 'process'), $article->text );
    }

    private function process($match) {
        $ret = '';
        $id = intval($match[1]); //second element of array contains the ID#
        if ($id) {

            // Get an instance of the songs model
            $model = JModelLegacy::getInstance('Song', 'GuitarModel', array('ignore_request' => true));
            $item = $model->getItem($id);
            $ret .= '<h3>'.$item->album.'</h3>';
            $ret .= '<div>'.$item->song.'</div>';
            $ret = '<div class="songwrap">'.$ret.'</div>';
        }
        return $ret;
    }

}