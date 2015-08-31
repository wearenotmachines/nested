<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $granddaddy = factory(App\Item::class)->create();
    	$parents = factory(App\Item::class, 10)->create();
        foreach ($parents AS $parent) {
            $granddaddy->children()->save($parent);
            if (rand(1,10)>3) {
                $numChildren = rand(1,4);
                echo $parent->label." will have $numChildren children\n";
                $children = factory(App\Item::class, $numChildren)->create();
                if (!$children instanceof Collection) $children = Collection::make([$children]);
                foreach ($children AS $child) {
                    echo "\t".$parent->label." has child ".$child->label."\n";
                    $parent->children()->save($child);
                    if (rand(1,10)>5) {
                        $numGrandChildren = rand(1,3);
                        echo "\t\t".$child->label." will have $numGrandChildren children\n";
                        $grandChildren = factory(App\Item::class, $numGrandChildren)->create();
                        if (!$grandChildren instanceof Collection) $grandChildren = Collection::make([$grandChildren]);
                        foreach ($grandChildren AS $grandchild) {
                            $child->children()->save($grandchild);
                            echo "\t\t".$parent->label." has child ".$child->label." with child ".$grandchild->label."\n";
                            if (rand(1,10)>6) {
                                $numGreatGrandchildren = rand(1,3);
                                echo "\t\t\t".$grandchild->label." will have $numGreatGrandchildren children\n";
                                $greatGrandchildren = factory(App\Item::class, $numGreatGrandchildren)->create();
                                if (!$greatGrandchildren instanceof Collection) $greatGrandchildren = Collection::make([$greatGrandchildren]);
                                foreach ($greatGrandchildren AS $greatGrandchild) {
                                    $grandchild->children()->save($greatGrandchild);
                                    echo "\t\t\t".$parent->label." has child ".$child->label." with child ".$grandchild->label." who has child ".$greatGrandchild->label."\n";
                                }
                            } else {
                                echo "\t\t".$grandchild->label." has no children\n";
                            }
                        }
                    } else {
                        echo "\t".$child->label." has no children\n";
                    }
                }
            } else {
                echo $parent->label." has no children\n";
            }
            App\Item::rebuild();
        }
    }
}
