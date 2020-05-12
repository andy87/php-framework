<?php
/** @var string $class */
/** @var string $method */

?>


<style>
    #menu {
        margin: 0;
        padding: 0;
    }
    #menu LI {
        display: inline-block;
        padding: 5px 10px;
        margin: 2px;
    }
</style>


<ul id="menu">
    <li><a href="/index"><button>index</button></a></li>
    <li><a href="/login"><button>login</button></a></li>
    <li><a href="/contact"><button>contact</button></a></li>
    <li><a href="/profile/username/admin"><button>profile/username/admin</button></a></li>
    <li><a href="/profile/user-id/1"><button>profile/user-id/1</button></a></li>
    <li><a href="/profile/test-action"><button><?=htmlspecialchars('<action>/<controller>')?></button></a></li>
</ul>


<ul style="font-size: 22px; line-height: 32px">
    <li> CLASS : <?= $class ?> </li>
    <li> METHOD : <?= $method ?> </li>
</ul>