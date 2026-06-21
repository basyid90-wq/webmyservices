import { useState, useEffect, useCallback } from 'react'

const CART_KEY = 'shop_cart'

function loadCart() {
  try {
    const raw = localStorage.getItem(CART_KEY)
    if (raw) {
      const parsed = JSON.parse(raw)
      if (Array.isArray(parsed.items)) return parsed
    }
  } catch {}
  return { items: [], updated_at: Date.now() }
}

function saveCart(cart) {
  try {
    localStorage.setItem(CART_KEY, JSON.stringify({ ...cart, updated_at: Date.now() }))
  } catch {}
}

export default function useShopCart() {
  const [cart, setCart] = useState(loadCart)

  const addItem = useCallback((product) => {
    setCart((prev) => {
      const existing = prev.items.find((i) => i.product_id === product.id)
      let next
      if (existing) {
        next = {
          ...prev,
          items: prev.items.map((i) =>
            i.product_id === product.id ? { ...i, quantity: i.quantity + 1 } : i
          ),
        }
      } else {
        next = {
          ...prev,
          items: [...prev.items, { product_id: product.id, name: product.name, price: product.price, quantity: 1 }],
        }
      }
      saveCart(next)
      return next
    })
  }, [])

  const updateQty = useCallback((productId, quantity) => {
    setCart((prev) => {
      const next = {
        ...prev,
        items: quantity <= 0
          ? prev.items.filter((i) => i.product_id !== productId)
          : prev.items.map((i) => (i.product_id === productId ? { ...i, quantity } : i)),
      }
      saveCart(next)
      return next
    })
  }, [])

  const removeItem = useCallback((productId) => {
    setCart((prev) => {
      const next = { ...prev, items: prev.items.filter((i) => i.product_id !== productId) }
      saveCart(next)
      return next
    })
  }, [])

  const clearCart = useCallback(() => {
    const next = { items: [], updated_at: Date.now() }
    saveCart(next)
    setCart(next)
  }, [])

  const itemCount = cart.items.reduce((sum, i) => sum + i.quantity, 0)
  const subtotal = cart.items.reduce((sum, i) => sum + i.price * i.quantity, 0)

  return { cart, addItem, updateQty, removeItem, clearCart, itemCount, subtotal }
}
