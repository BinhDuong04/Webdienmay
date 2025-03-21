<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'quantity'];

    public function getCartItems($userId)
    {
        return $this->select('cart.id, cart.user_id, cart.product_id, cart.quantity, products.name, products.price, products.image')
                    ->join('products', 'cart.product_id = products.id')
                    ->where('cart.user_id', $userId)
                    ->findAll();
    }

    public function getCartItemCount($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }

    public function addToCart($userId, $productId, $quantity)
    {
        $cartItem = $this->where(['user_id' => $userId, 'product_id' => $productId])->first();

        if ($cartItem) {
            $newQuantity = $cartItem['quantity'] + $quantity;
            return $this->update($cartItem['id'], ['quantity' => $newQuantity]);
        } else {
            return $this->insert([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
    }
}