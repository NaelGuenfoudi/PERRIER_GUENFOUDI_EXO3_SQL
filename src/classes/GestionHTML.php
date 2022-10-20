<?php

class GestionHTML
{
    public static function menu() : string {
        return
            '<form name="f1">
                <select name="action" onchange="this.form.submit()">
                    <option value="SELECTION">accueil</option>
                    <option value="quest1"
                    <?php if ($page == "quest1") {
                    echo " selected";
                    } ?> >quest1
                    <option value="quest2">question2
                    </option>
                    <option value="quest3">question3
                    </option>
                    <option value="quest4">question4
                    </option>
                    <option value="quest5">question5
                    </option>
                </select>
            </form>';
    }
}