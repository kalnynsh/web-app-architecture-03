<?php

/** @var \Model\Entity\User $user */
/** @var bool $isLogged */
/** @var \Closure $path */
$body = function () use ($user) {
    ?>
    <form method="post">
        <table cellpadding="10">
            <tr>
                <td colspan="3" align="center">Дорогой покупатель <?= $user->getName()} ?></td>
                <td colspan="3" align="center">Покупка успешно совершена</td>
            </tr>
        </table>
    </form>
    <?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Покупка',
        'body' => $body,
    ]
);
