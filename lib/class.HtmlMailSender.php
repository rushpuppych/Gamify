<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once '../vendor/PHPMailer/src/Exception.php';
include_once '../vendor/PHPMailer/src/PHPMailer.php';
include_once '../vendor/PHPMailer/src/SMTP.php';

class HtmlMailSender
{
    public function sendEmail($strBetreff, $strHtmlContent, $mixToEmail, $strFrom = '')
    {
        // Ziel Adressen aufbereiten
        $strEmailTo = $mixToEmail;
        if(is_array($mixToEmail)) {
            $strEmailTo = implode(', ', $mixToEmail);
        }

        // From Adress Setzen
        $arrConfig = getConfig('page');
        if(empty($strFrom)) {
          $strFrom = $arrConfig['impressum_email'];
        }

        // Email Header
        $strHead = '<div style="width: 100%; height: 60px; background-color: #343a40; overflow: hidden;">';
        $strHead .= '  <div style="padding: 5px;">';
        $strHead .= '    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 70px; fill: #ffffff;"><path d="M480 96H160C71.6 96 0 167.6 0 256s71.6 160 160 160c44.8 0 85.2-18.4 114.2-48h91.5c29 29.6 69.5 48 114.2 48 88.4 0 160-71.6 160-160S568.4 96 480 96zM256 276c0 6.6-5.4 12-12 12h-52v52c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-52H76c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h52v-52c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h52c6.6 0 12 5.4 12 12v40zm184 68c-26.5  0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-80c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48z"/></svg>';
        $strHead .= '    <span style="color: #ffffff; font-size: 24px; font-weight: bold; padding-top: 10px; margin-left: 10px; position: absolute;">Gamify</span>';
        $strHead .= '  </div>';
        $strHead .= '</div>';

        // HTML Template erstellen
        $strHtmlContent = $this->getHtmlTemplate($strHtmlContent, $strBetreff, $strHead);

        // USE PHP MAILER
        $arrConfig = getConfig('mail');
        $objMailer = new PHPMailer(true);
        $objMailer->isSMTP();
        $objMailer->Host = $arrConfig['host'];
        $objMailer->SMTPAuth = $arrConfig['smtp_auth'];
        $objMailer->Username = $arrConfig['username'];
        $objMailer->Password = $arrConfig['password'];
        $objMailer->SMTPSecure = $arrConfig['smtp_secure'];
        $objMailer->Port = $arrConfig['port'];

        //Recipients
        $objMailer->setFrom($strFrom);
        $objMailer->addAddress($strEmailTo);

        //Content
        $objMailer->isHTML(true);
        $objMailer->Subject = utf8_decode($strBetreff);
        $objMailer->Body = utf8_decode($strHtmlContent);
        $objMailer->send();
    }

    public function getEmail($strBetreff, $strHtmlContent, $strHeaderContent = '')
    {
        $strContent = $this->getHtmlTemplate($strHtmlContent, $strBetreff, $strHeaderContent);
        return $strContent;
    }

    private function getHtmlTemplate($strBodyContent, $strBetreff, $strHeaderContent = '')
    {
        $arrConfig = getConfig('page');

        $strHtml = '<!doctype html>';
        $strHtml .= '<html>';
        $strHtml .= '  <head>';
        $strHtml .= '    <meta name="viewport" content="width=device-width">';
        $strHtml .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        $strHtml .= '    <title>' . $strBetreff . '</title>';
        $strHtml .= '    <style>';
        $strHtml .= '    /* -------------------------------------';
        $strHtml .= '        INLINED WITH htmlemail.io/inline';
        $strHtml .= '    ------------------------------------- */';
        $strHtml .= '    /* -------------------------------------';
        $strHtml .= '        RESPONSIVE AND MOBILE FRIENDLY STYLES';
        $strHtml .= '    ------------------------------------- */';
        $strHtml .= '    @media only screen and (max-width: 620px) {';
        $strHtml .= '      table[class=body] h1 {';
        $strHtml .= '        font-size: 28px !important;';
        $strHtml .= '        margin-bottom: 10px !important;';
        $strHtml .= '      }';
        $strHtml .= '      table[class=body] p,';
        $strHtml .= '            table[class=body] ul,';
        $strHtml .= '            table[class=body] ol,';
        $strHtml .= '            table[class=body] td,';
        $strHtml .= '            table[class=body] span,';
        $strHtml .= '            table[class=body] a {';
        $strHtml .= '        font-size: 16px !important;';
        $strHtml .= '      }';
        $strHtml .= '      table[class=body] .wrapper,';
        $strHtml .= '            table[class=body] .article {';
        $strHtml .= '        padding: 10px !important;';
        $strHtml .= '      }';
        $strHtml .= '      table[class=body] .content {';
        $strHtml .= '        padding: 0 !important;';
        $strHtml .= '      }';
        $strHtml .= '      table[class=body] .container {';
        $strHtml .= '        padding: 0 !important;';
        $strHtml .= '        width: 100% !important;';
        $strHtml .= '      }';
        $strHtml .= '      table[class=body] .main {';
        $strHtml .= '        border-left-width: 0 !important;';
        $strHtml .= '        border-radius: 0 !important;';
        $strHtml .= '        border-right-width: 0 !important;';
        $strHtml .= '      }';
        $strHtml .= '      table[class=body] .btn table {';
        $strHtml .= '        width: 100% !important;';
        $strHtml .= '      }';
        $strHtml .= '      table[class=body] .btn a {';
        $strHtml .= '        width: 100% !important;';
        $strHtml .= '      }';
        $strHtml .= '      table[class=body] .img-responsive {';
        $strHtml .= '        height: auto !important;';
        $strHtml .= '        max-width: 100% !important;';
        $strHtml .= '        width: auto !important;';
        $strHtml .= '      }';
        $strHtml .= '    }';
        $strHtml .= '    /* -------------------------------------';
        $strHtml .= '        PRESERVE THESE STYLES IN THE HEAD';
        $strHtml .= '    ------------------------------------- */';
        $strHtml .= '    @media all {';
        $strHtml .= '      .ExternalClass {';
        $strHtml .= '        width: 100%;';
        $strHtml .= '      }';
        $strHtml .= '      .ExternalClass,';
        $strHtml .= '            .ExternalClass p,';
        $strHtml .= '            .ExternalClass span,';
        $strHtml .= '            .ExternalClass font,';
        $strHtml .= '            .ExternalClass td,';
        $strHtml .= '            .ExternalClass div {';
        $strHtml .= '        line-height: 100%;';
        $strHtml .= '      }';
        $strHtml .= '      .apple-link a {';
        $strHtml .= '        color: inherit !important;';
        $strHtml .= '        font-family: inherit !important;';
        $strHtml .= '        font-size: inherit !important;';
        $strHtml .= '        font-weight: inherit !important;';
        $strHtml .= '        line-height: inherit !important;';
        $strHtml .= '        text-decoration: none !important;';
        $strHtml .= '      }';
        $strHtml .= '      .btn-primary table td:hover {';
        $strHtml .= '        background-color: #34495e !important;';
        $strHtml .= '      }';
        $strHtml .= '      .btn-primary a:hover {';
        $strHtml .= '        background-color: #34495e !important;';
        $strHtml .= '        border-color: #34495e !important;';
        $strHtml .= '      }';
        $strHtml .= '    }';
        $strHtml .= '    </style>';
        $strHtml .= '  </head>';
        $strHtml .= '  <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">';
        $strHtml .= '    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">';
        $strHtml .= '      <tr>';
        $strHtml .= '        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>';
        $strHtml .= '        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">';
        $strHtml .= '          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">';
        $strHtml .= '';
        $strHtml .= '            <!-- START CENTERED WHITE CONTAINER -->';
        $strHtml .= '            <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">This is preheader text. Some clients will show this text as a preview.</span>';
        $strHtml .= '            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">';
        $strHtml .= '              <tr>';
        $strHtml .= '                 <td>' . $strHeaderContent . '</td>';
        $strHtml .= '              </tr>';
        $strHtml .= '              <!-- START MAIN CONTENT AREA -->';
        $strHtml .= '              <tr>';
        $strHtml .= '                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">';
        $strHtml .= '                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">';
        $strHtml .= '                    <tr>';
        $strHtml .= '                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">';
        $strHtml .= '                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">' . $strBodyContent . '</p>';
        $strHtml .= '                      </td>';
        $strHtml .= '                    </tr>';
        $strHtml .= '                  </table>';
        $strHtml .= '                </td>';
        $strHtml .= '              </tr>';
        $strHtml .= '';
        $strHtml .= '            <!-- END MAIN CONTENT AREA -->';
        $strHtml .= '            </table>';
        $strHtml .= '';
        $strHtml .= '            <!-- START FOOTER -->';
        $strHtml .= '            <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">';
        $strHtml .= '              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">';
        $strHtml .= '                <tr>';
        $strHtml .= '                  <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">';
        $strHtml .= '                    <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">' . $arrConfig['impressum_name'] . ', ' . $arrConfig['impressum_street'] . ', ' . $arrConfig['impressum_place'] . '</span>';
        $strHtml .= '                  </td>';
        $strHtml .= '                </tr>';
        $strHtml .= '                <tr>';
        $strHtml .= '                  <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">';
        $strHtml .= '                    Powered by <a href="' . $arrConfig['impressum_website'] . '" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">' . $arrConfig['impressum_website'] . '</a>.';
        $strHtml .= '                  </td>';
        $strHtml .= '                </tr>';
        $strHtml .= '              </table>';
        $strHtml .= '            </div>';
        $strHtml .= '            <!-- END FOOTER -->';
        $strHtml .= '';
        $strHtml .= '          <!-- END CENTERED WHITE CONTAINER -->';
        $strHtml .= '          </div>';
        $strHtml .= '        </td>';
        $strHtml .= '        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>';
        $strHtml .= '      </tr>';
        $strHtml .= '    </table>';
        $strHtml .= '  </body>';
        $strHtml .= '</html>';
        return $strHtml;
    }
}
