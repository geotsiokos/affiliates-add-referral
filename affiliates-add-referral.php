<?php
/**
 * Plugin Name: Affiliates Add Referral
 * Plugin URI: http://www.netpad.gr
 * Description: Adds a referral with specified parameters
 * Version: 1.0.0
 * Author: George Tsiokos
 * Author URI: http://www.netpad.gr
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright (c) 2015-2016 "gtsiokos" George Tsiokos www.netpad.gr
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * WC tested up to: 3.7.0
 *
 * @package affiliates-add-referral
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
Affiliate ID: 3
OrderID: 4531 (parent order)
$0 total as it started with a free trial.
Subscription amoutn changes each month, most recent was GBP: 491.53
Affiliate rate is 10%, so GBP:49.15 for that order.
*/

if ( class_exists( 'Affiliates_Referral_Controller' ) ) {
	$affiliate_id = 3;
	if ( affiliates_check_affiliate_id( $affiliate_id ) ) {
		$amount = '49.15';
		$order_id = 4531;
		$order_total = 491.53;
		$currency = 'GBP';
		$order_link = '<a href="' . admin_url( 'post.php?post=' . $order_id . '&action=edit' ) . '">';
		$order_link .= sprintf( __( 'Order #%s', AFF_WOOCOMMERCE_PLUGIN_DOMAIN ), $order_id );
		$order_link .= "</a>";

		$data = array(
			'order_id' => array(
				'title' => 'Order #',
				'domain' => AFF_WOOCOMMERCE_PLUGIN_DOMAIN,
				'value' => esc_sql( $order_id )
			),
			'order_total' => array(
				'title' => 'Total',
				'domain' =>  AFF_WOOCOMMERCE_PLUGIN_DOMAIN,
				'value' => esc_sql( $order_total )
			),
			'order_currency' => array(
				'title' => 'Currency',
				'domain' =>  AFF_WOOCOMMERCE_PLUGIN_DOMAIN,
				'value' => esc_sql( $currency )
			),
			'order_link' => array(
				'title' => 'Order',
				'domain' =>  AFF_WOOCOMMERCE_PLUGIN_DOMAIN,
				'value' => esc_sql( $order_link )
			)
		);
		$params= array();
		$params['affiliate_id'] = $affiliate_id;
		$params['post_id'] = 4531;
		$params['description'] = sprintf( 'Order #%s', $order_id );
		$params['data'] = $data;
		$params['amount'] = $amount;
		$params['currency_id'] = 'GBP';
		$params['status'] = 'AFFILIATES_REFERRAL_STATUS_ACCEPTED';
		$params['type'] = 'sale';
		$params['reference'] = $order_id;
		$params['reference_amount'] = $order_total;
		$arc = new Affiliates_Referral_Controller();
		$arc->add_referral( $params );
	}
}
