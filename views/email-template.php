<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            body {
                font-family: Helvetica, sans-serif;
                -webkit-font-smoothing: antialiased;
                font-size: 16px;
                line-height: 1.3;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                background-color: #f4f5f6;
                margin: 0;
                padding: 0;
                border-radius: 5px;
            }

            .body-table {
                border-collapse: separate;
                background-color: #f4f5f6;
                width: 100%;
                border-radius: 5px;
            }

            .container {
                max-width: 600px;
                padding: 0;
                padding-top: 24px;
                padding-bottom: 24px;
                width: 600px;
                margin: 0 auto;
            }

            .content {
                box-sizing: border-box;
                display: block;
                margin: 0 auto;
                max-width: 600px;
                padding: 0;
            }

            .main-table {
                border-collapse: separate;
                background: #ffffff;
                border: 1px solid #eaebed;
                border-radius: 16px;
                width: 100%;
            }

            .wrapper {
                box-sizing: border-box;
                padding: 24px;
            }

            .text {
                font-family: Helvetica, sans-serif;
                font-size: 16px;
                font-weight: normal;
                margin: 0;
                margin-bottom: 16px;
            }
        </style>
    </head>

    <body>
        <table class="body-table">
            <tr>
                <td valign="top">&nbsp;</td>
                <td class="container" valign="top">
                    <div class="content">
                        <table role="presentation" class="main-table">
                            <!-- START MAIN CONTENT AREA -->
                            <tr>
                                <td class="wrapper" valign="top">
                                    <p class="text"><?php _e( 'Hi', 'talent-portal' )?> <b><?php echo $name; ?></b></b></p>

                                    <p class="text">
                                        <?php _e( 'Your application for the position', 'talent-portal' )?> <b><?php echo $post_name; ?></b>
                                        <?php _e( 'has been received.', 'talent-portal' )?>
                                    </p>

                                    <p class="text">
                                        <?php _e( 'All applications will go through a rigorous screening process which has multiple
                                        steps. You will receive notifications regarding the next steps of our
                                        recruitment.', 'talent-portal' )?>
                                    </p>
                                    <p class="text">
                                        <?php _e( 'Thanks for your interest, we look forward to getting to know you better!', 'talent-portal' )?>
                                    </p>
                                    <p class="text">
                                        <?php _e( 'Best regards,', 'talent-portal' )?>
                                    </p>
                                    <p class="text">
                                        <b><?php _e( 'Talent Portal Team', 'talent-portal' )?></b>
                                    </p>
                                </td>
                            </tr>
                            <!-- END MAIN CONTENT AREA -->
                        </table>
                        <!-- END CENTERED WHITE CONTAINER -->
                    </div>
                </td>
                <td valign="top">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
