<?php

use yii\helpers\Url;

/**
 * @var string $subject
 * @var \app\modules\user\models\User $user
 * @var \app\modules\user\models\UserToken $userToken
 */
?>

<!-- HEADER -->
<!-- Set text color and font family ("sans-serif" or "Georgia, serif") -->
<tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 24px; font-weight: bold; line-height: 130%;
			padding-top: 25px;
			color: #000000;
			font-family: sans-serif;" class="header">
        <?= $subject ?>
    </td>
</tr>

<!-- PARAGRAPH -->
<!-- Set text color and font family ("sans-serif" or "Georgia, serif"). Duplicate all text styles in links, including line-height -->
<tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
			padding-top: 25px;
			color: #000000;
			font-family: sans-serif;" class="paragraph">
        <?= Yii::t("user", "Please use this link to reset your password:") ?>
    </td>
</tr>

<!-- BUTTON -->
<!-- Set button background color at TD, link/text color at A and TD, font family ("sans-serif" or "Georgia, serif") at TD. For verification codes add "letter-spacing: 5px;". Link format: http://domain.com/?utm_source={{Campaign-Source}}&utm_medium=email&utm_content={{Button-Name}}&utm_campaign={{Campaign-Name}} -->
<tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%;
			padding-top: 25px;
			padding-bottom: 5px;" class="button"><a
            href="<?= Url::toRoute(["/user/reset", "token" => $userToken->token], true); ?>" target="_blank"
            style="text-decoration: underline;">
            <table border="0" cellpadding="0" cellspacing="0" align="center"
                   style="max-width: 240px; min-width: 120px; border-collapse: collapse; border-spacing: 0; padding: 0;">
                <tr>
                    <td align="center" valign="middle"
                        style="padding: 12px 24px; margin: 0; text-decoration: underline; border-collapse: collapse; border-spacing: 0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; -khtml-border-radius: 4px;"
                        bgcolor="#E9703E"><a target="_blank" style="text-decoration: underline;
					color: #FFFFFF; font-family: sans-serif; font-size: 17px; font-weight: 400; line-height: 120%;"
                                             href="<?= Url::toRoute(["/user/reset", "token" => $userToken->token], true); ?>">
                            <?= Yii::t('app', 'Click to reset password') ?>
                        </a>
                    </td>
                </tr>
            </table>
        </a>
    </td>
</tr>

<tr>
    <td align="center" valign="top" style="border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; font-size: 17px; font-weight: 400; line-height: 160%;
			padding-top: 25px;
			color: #000000;
			font-family: sans-serif;" class="paragraph">
        <?= Url::toRoute(["/user/reset", "token" => $userToken->token], true); ?>
    </td>
</tr>
