<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Application Submission List', TALENT_PORTAL_TEXT_DOMAIN );?></h1>

    <?php if ( isset( $_GET[ 'talent-deleted' ] ) && $_GET[ 'talent-deleted' ] == 'true' ) {?>
        <div class="notice notice-success">
            <p><?php _e( 'Talent has been deleted successfully!', TALENT_PORTAL_TEXT_DOMAIN );?></p>
        </div>
    <?php }?>

    <form  method="post">
        <?php \TalentPortal\Admin\ApplicationList::instance();?>
    </form>
</div>