<?php

namespace App;

use Baum\Node;

class Item extends Node
{
    protected $table = "items";
    protected $fillable = ["label"];

    public static function showTree($node) {
		if($node->isLeaf()) {
			return '<li data-item-id="'.$node->id.'">' . $node->label . '</li>';
		} else {
			$html = '<li data-item-id="'.$node->id.'">' . $node->label;

			$html .= '<ul data-parent-id="'.$node->id.'">';

			foreach($node->children as $child) {
				$html .= static::showTree($child);

				$html .= '</ul>';

				$html .= '</li>';
			}

			return $html;
		}
    }
}
