<?php

// A template view in which HTML entities have been decoded for XML
// compatibility.  This is specifically used for the copyright notice, which
// uses both &copy; and &ndash;.  These entities are legal in HTML, but not XML.
// We could use the numeric entities everywhere, but it's much more readable to
// be able to use the named HTML entities in our markup.

class XmlTemplateView extends TemplateView {

	public function display () {
		ob_start();
		parent::display();
		echo html_entity_decode(ob_get_clean());
	}
}

?>
