import { ButtonHTMLAttributes } from 'react'
import { cn } from '@/lib/utils'

const variants = {
  primary: 'bg-indigo-600 hover:bg-indigo-700 text-white border-transparent',
  secondary: 'bg-white/10 hover:bg-white/15 text-white border-white/10',
  outline: 'bg-transparent hover:bg-white/5 text-white border-gray-700 hover:border-indigo-500',
  ghost: 'bg-transparent hover:bg-white/5 text-gray-400 hover:text-white border-transparent',
}

const sizes = {
  sm: 'px-3 py-1.5 text-sm rounded-lg',
  md: 'px-5 py-2.5 text-sm rounded-lg',
  lg: 'px-8 py-3.5 text-base rounded-lg',
}

export default function Button({ variant = 'primary', size = 'lg', className, children, ...props }) {
  return (
    <button
      className={cn(
        'inline-flex items-center justify-center gap-2 font-medium border transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500/50',
        variants[variant],
        sizes[size],
        className
      )}
      {...props}
    >
      {children}
    </button>
  )
}
