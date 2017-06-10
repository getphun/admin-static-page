INSERT IGNORE INTO `user_perms` ( `name`, `group`, `role`, `about` ) VALUES
    ( 'create_static_page',  'Static Page', 'Management', 'Allow user to create new static page' ),
    ( 'read_static_page',    'Static Page', 'Management', 'Allow user to view all static pages' ),
    ( 'remove_static_page',  'Static Page', 'Management', 'Allow user to remove exists static page' ),
    ( 'update_static_page',  'Static Page', 'Management', 'Allow user to update exists static page' );