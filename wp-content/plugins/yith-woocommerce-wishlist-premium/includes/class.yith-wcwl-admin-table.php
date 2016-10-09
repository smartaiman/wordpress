<?php
/**
 * Admin table class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCWL_Admin_Table' ) ) {
    /**
     * Admin view class. Create and populate "user with wishlists" table
     *
     * @since 1.0.0
     */
    class YITH_WCWL_Admin_Table extends WP_List_Table {

        /**
         * Class constructor method
         *
         * @return \YITH_WCWL_Admin_Table
         * @since 2.0.0
         */
        public function __construct(){
            global $status, $page;

            //Set parent defaults
            parent::__construct( array(
                'singular'  => 'wishlist',     //singular name of the listed records
                'plural'    => 'wishlists',    //plural name of the listed records
                'ajax'      => false        //does this table support ajax?
            ) );
        }

        /**
         * Default columns print method
         *
         * @param $item array Associative array of element to print
         * @param $column_name string Name of the column to print
         *
         * @return string
         * @since 2.0.0
         */
        public function column_default( $item, $column_name ){
            if( isset( $item[$column_name] ) ){
                return esc_html( $item[$column_name] );
            }
            else{
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
            }
        }

        /**
         * Prints column for wishlist user
         *
         * @param $item array Item to use to print record
         * @return string
         * @since 2.0.0
         */
        public function column_cb( $item ) {
            return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                $this->_args['singular'],  //Let's simply repurpose the table's singular label
                $item['ID']                //The value of the checkbox should be the record's id
            );
        }

        /**
         * Return username column for an item
         *
         * @param $item array Item to use to print record
         * @return string
         * @since 2.0.0
         */
        public function column_username( $item ) {
            $row = "";

            if( isset( $item['user_id'] ) ){
                $user = get_user_by( 'id', $item['user_id'] );

                if( ! empty( $user ) ) {
                    $row = sprintf(
                        "%s<strong><a href='%s'>%s</a></strong>",
                        get_avatar( $item['user_id'], 32 ),
                        get_edit_user_link( $item['user_id'] ),
                        $user->user_login
                    );
                }
            }

            return $row;
        }

        /**
         * Prints column for wishlist name
         *
         * @param $item array Item to use to print record
         * @return string
         * @since 2.0.0
         */
        public function column_name( $item ){
            $row = "";

	        $actions = array(
		        'view' => sprintf( '<a href="%s">%s</a>', YITH_WCWL()->get_wishlist_url( 'view' . '/' . $item['wishlist_token'] ), __( 'View', 'yith-woocommerce-wishlist' ) ),
		        'delete' => sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( array( 'action' => 'delete_wishlist', 'wishlist_id' => $item['ID'] ), wp_nonce_url( admin_url( 'admin.php' ), 'delete_wishlist', 'delete_wishlist' ) ) ), __( 'Delete', 'yith-woocommerce-wishlist' ) )
	        );

            if( isset( $item['wishlist_name'] ) ){
                $row = sprintf(
                    "<a href='%s'>%s</a>%s",
                    YITH_WCWL()->get_wishlist_url( 'view' . '/' . $item['wishlist_token'] ),
                    ( ! empty( $item['wishlist_name'] ) ) ? $item['wishlist_name'] : get_option( 'yith_wcwl_wishlist_title' ),
	                $this->row_actions( $actions )
                );
            }

            return $row;
        }

        /**
         * Prints column for wishlist privacy
         *
         * @param $item array Item to use to print record
         * @return string
         * @since 2.0.0
         */
        public function column_privacy( $item ) {
            $row = "";

            if( isset( $item['wishlist_privacy'] ) ){
                switch( $item['wishlist_privacy'] ){
                    case 0:
                        $row = __( 'Public', 'yith-woocommerce-wishlist' );
                        break;
                    case 1:
                        $row = __( 'Shared', 'yith-woocommerce-wishlist' );
                        break;
                    case 2:
                        $row = __( 'Private', 'yith-woocommerce-wishlist' );
                        break;
                    default:
                        $row = __( 'N/D', 'yith-woocommerce-wishlist' );
                        break;
                }
            }

            return $row;
        }

        /**
         * Prints column for wishlist number of items
         *
         * @param $item array Item to use to print record
         * @return string
         * @since 2.0.0
         */
        public function column_items( $item ){
            $row = "";

            if( isset( $item['wishlist_token'] ) ){
                $row = YITH_WCWL()->count_products( $item['wishlist_token'] );
            }

            return $row;
        }

        /**
         * Returns columns available in table
         *
         * @return array Array of columns of the table
         * @since 2.0.0
         */
        public function get_columns(){
            $columns = array(
                'cb'        => '<input type="checkbox" />',
                'name'      => __( 'Name', 'yith-woocommerce-wishlist' ),
                'username'  => __( 'Username', 'yith-woocommerce-wishlist' ),
                'privacy'   => __( 'Privacy', 'yith-woocommerce-wishlist' ),
                'items'     => __( 'Items in wishlist', 'yith-woocommerce-wishlist' )
            );
            return $columns;
        }

        /**
         * Returns column to be sortable in table
         *
         * @return array Array of sortable columns
         * @since 2.0.0
         */
        public function get_sortable_columns() {
            $sortable_columns = array(
                'name'      => array( 'wishlist_name', false ),     //true means it's already sorted
                'username'  => array( 'user_login', false ),
                'privacy'   => array( 'wishlist_privacy', false )
            );
            return $sortable_columns;
        }

        /**
         * Sets bulk actions for table
         *
         * @return array Array of available actions
         * @since 2.0.0
         */
        public function get_bulk_actions() {
            $actions = array(
                'delete'    => 'Delete'
            );
            return $actions;
        }
        
        /**
         * Returns views for wishlist page
         *
         * @return array
         * @since 2.0.0
         */
        public function get_views() {
            $views = array(
                'all' => sprintf(
                    "<a href='%s' class='%s'>%s <span class='count'>(%d)</span></a>",
                    esc_url( add_query_arg( 'wishlist_privacy', 'all' ) ),
                    ( empty( $_GET['wishlist_privacy'] ) || isset( $_GET['wishlist_privacy'] ) && $_GET['wishlist_privacy'] == 'all' ) ? 'current' : '',
                    __( 'All', 'yith-woocommerce-wishlist' ),
                    count( YITH_WCWL()->get_wishlists( array( 'user_id' => false, 'wishlist_visibility' => 'all', 'show_empty' => false ) ) )
                ),
                'public'  => sprintf(
                    "<a href='%s' class='%s'>%s <span class='count'>(%d)</span></a>",
	                esc_url( add_query_arg( 'wishlist_privacy', 'public' ) ),
                    ( isset( $_GET['wishlist_privacy'] ) && $_GET['wishlist_privacy'] == 'public' ) ? 'current' : '',
                    __( 'Public', 'yith-woocommerce-wishlist' ),
                    count( YITH_WCWL()->get_wishlists( array( 'user_id' => false, 'wishlist_visibility' => 'public', 'show_empty' => false ) ) )
                ),
                'shared'  => sprintf(
                    "<a href='%s' class='%s'>%s <span class='count'>(%d)</span></a>",
	                esc_url( add_query_arg( 'wishlist_privacy', 'shared' ) ),
                    ( isset( $_GET['wishlist_privacy'] ) && $_GET['wishlist_privacy'] == 'shared' ) ? 'current' : '',
                    __( 'Shared', 'yith-woocommerce-wishlist' ),
                    count( YITH_WCWL()->get_wishlists( array( 'user_id' => false, 'wishlist_visibility' => 'shared', 'show_empty' => false ) ) )
                ),
                'private' => sprintf(
                    "<a href='%s' class='%s'>%s <span class='count'>(%d)</span></a>",
	                esc_url( add_query_arg( 'wishlist_privacy', 'private' ) ),
                    ( isset( $_GET['wishlist_privacy'] ) && $_GET['wishlist_privacy'] == 'private' ) ? 'current' : '',
                    __( 'Private', 'yith-woocommerce-wishlist' ),
                    count( YITH_WCWL()->get_wishlists( array( 'user_id' => false, 'wishlist_visibility' => 'private', 'show_empty' => false ) ) )
                )
            );

            return $views;
        }

        /**
         * Delete wishlist on bulk action
         *
         * @return void
         * @since 2.0.0
         */
        public function process_bulk_action() {
            //Detect when a bulk action is being triggered...
            if( 'delete' === $this->current_action() && ! empty( $_REQUEST[ $this->_args['singular'] ] ) ) {
                foreach( $_REQUEST[ $this->_args['singular'] ] as $wishlist_id ){
                    YITH_WCWL_Premium()->remove_wishlist( $wishlist_id );
                }
            }
        }

        /**
         * Prepare items for table
         *
         * @return void
         * @since 2.0.0
         */
        public function prepare_items() {
            global $wpdb; //This is used only if making any database queries

            // sets pagination arguments
            $per_page = 20;
            $current_page = $this->get_pagenum();
            $total_items = count( YITH_WCWL()->get_wishlists( array(
	            'user_id' => false,
	            'user_search' => isset( $_REQUEST['s'] ) ? $_REQUEST['s'] : false,
	            'wishlist_visibility' => isset( $_REQUEST['wishlist_privacy'] ) ? $_REQUEST['wishlist_privacy'] : 'all',
	            'show_empty' => false
            ) ) );

            // sets columns headers
            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();
            $this->_column_headers = array( $columns, $hidden, $sortable );

            // process bulk actions
            $this->process_bulk_action();

            // retrieve data for table
            $this->items = YITH_WCWL()->get_wishlists( array(
                'user_id' => false,
                'orderby' => ( ! empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'wishlist_name',
                'order' => ( ! empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'asc',
                'limit' => $per_page,
                'offset' => ( ( $current_page - 1 ) * $per_page ),
                'user_search' => isset( $_REQUEST['s'] ) ? $_REQUEST['s'] : false,
                'wishlist_visibility' => isset( $_REQUEST['wishlist_privacy'] ) ? $_REQUEST['wishlist_privacy'] : 'all',
	            'show_empty' => false
            ) );

            // sets pagination args
            $this->set_pagination_args( array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
                'total_pages' => ceil( $total_items / $per_page )
            ) );
        }
    }
}