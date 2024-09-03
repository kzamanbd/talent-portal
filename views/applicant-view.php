<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Application Submission List', 'talent-portal' );?></h1>

    <?php if ( isset( $_GET[ 'talent-deleted' ] ) && $_GET[ 'talent-deleted' ] == 'true' ) {?>
        <div class="notice notice-success">
            <p><?php _e( 'Application has been deleted successfully!', 'talent-portal' );?></p>
        </div>
    <?php }?>

    <form  method="post">
        <?php \TalentPortal\Admin\ApplicationList::instance();?>
    </form>
</div>