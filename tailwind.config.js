/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Primary - Biru Profesional (sesuai industri percetakan)
        primary: {
          DEFAULT: '#1e40af', // Biru profesional
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#1e40af',
          600: '#1d4ed8',
          700: '#1e3a8a',
          800: '#1e3a8a',
          900: '#172554',
          950: '#0f172a',
        },
        // Secondary - Cyan/Magenta untuk aksen percetakan
        secondary: {
          DEFAULT: '#0891b2', // Cyan
          50: '#ecfeff',
          100: '#cffafe',
          200: '#a5f3fc',
          300: '#67e8f9',
          400: '#22d3ee',
          500: '#0891b2',
          600: '#0e7490',
          700: '#155e75',
          800: '#164e63',
          900: '#083344',
        },
        // Accent - Magenta (CMYK color model)
        accent: {
          DEFAULT: '#c026d3', // Magenta
          50: '#fdf4ff',
          100: '#fae8ff',
          200: '#f5d0fe',
          300: '#f0abfc',
          400: '#e879f9',
          500: '#c026d3',
          600: '#a21caf',
          700: '#86198f',
          800: '#701a75',
          900: '#4a044e',
        },
        // Printing Colors - Warna CMYK
        printing: {
          cyan: '#00aeef',
          magenta: '#ec008c',
          yellow: '#fff200',
          black: '#231f20',
        },
        // Neutral - Untuk teks dan background
        neutral: {
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#1e293b',
          900: '#0f172a',
          950: '#020617',
        },
        // Warna untuk status dan notifikasi
        success: {
          DEFAULT: '#10b981',
          light: '#34d399',
          dark: '#059669',
        },
        warning: {
          DEFAULT: '#f59e0b',
          light: '#fbbf24',
          dark: '#d97706',
        },
        danger: {
          DEFAULT: '#ef4444',
          light: '#f87171',
          dark: '#dc2626',
        },
        info: {
          DEFAULT: '#3b82f6',
          light: '#60a5fa',
          dark: '#2563eb',
        },
        // Surface colors
        surface: {
          DEFAULT: '#ffffff',
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
        },
        // Paper colors
        paper: {
          white: '#ffffff',
          cream: '#fdf6e3',
          ivory: '#fffff0',
          gray: '#f5f5f5',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
        heading: ['Montserrat', 'Inter', 'sans-serif'],
        display: ['Montserrat', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
        mono: ['JetBrains Mono', 'monospace'], // Untuk kode/proses teknis
      },
      boxShadow: {
        // Shadow dengan warna biru profesional
        'dp': '0 4px 6px -1px rgba(30, 64, 175, 0.1), 0 2px 4px -1px rgba(30, 64, 175, 0.06)',
        'dp-lg': '0 10px 15px -3px rgba(30, 64, 175, 0.15), 0 4px 6px -2px rgba(30, 64, 175, 0.1)',
        'dp-xl': '0 20px 25px -5px rgba(30, 64, 175, 0.2), 0 10px 10px -5px rgba(30, 64, 175, 0.1)',
        'card': '0 4px 14px 0 rgba(30, 64, 175, 0.08)',
        'card-hover': '0 8px 25px 0 rgba(30, 64, 175, 0.15)',
        'soft': '0 2px 8px 0 rgba(0, 0, 0, 0.06)',
        'soft-lg': '0 4px 16px 0 rgba(0, 0, 0, 0.08)',
        'modal': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
        'print': '0 0 20px rgba(0, 174, 239, 0.15)', // Cyan shadow untuk efek printing
      },
      backgroundImage: {
        // Gradient dengan warna digital printing
        'gradient-primary': 'linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%)',
        'gradient-secondary': 'linear-gradient(135deg, #0891b2 0%, #155e75 100%)',
        'gradient-printing': 'linear-gradient(135deg, #1e40af 0%, #c026d3 100%)', // Biru + Magenta
        'gradient-cmyk': 'linear-gradient(135deg, #00aeef 0%, #ec008c 25%, #fff200 50%, #231f20 100%)',
        'gradient-print-radial': 'radial-gradient(circle at top right, #1e40af, #c026d3)',
        'gradient-paper': 'linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%)',
        'gradient-white': 'linear-gradient(180deg, #ffffff 0%, #f8fafc 100%)',
        'gradient-header': 'linear-gradient(90deg, #1e40af 0%, #0891b2 100%)',
        'gradient-subtle': 'linear-gradient(180deg, rgba(30, 64, 175, 0.03) 0%, transparent 100%)',
        'grid-pattern': 'linear-gradient(rgba(30, 64, 175, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(30, 64, 175, 0.05) 1px, transparent 1px)',
        'dot-pattern': 'radial-gradient(rgba(30, 64, 175, 0.1) 1px, transparent 1px)',
      },
      backgroundSize: {
        'grid-sm': '20px 20px',
        'grid-md': '40px 40px',
        'grid-lg': '60px 60px',
        'dot-sm': '20px 20px',
        'dot-md': '40px 40px',
      },
      zIndex: {
        '100': '100',
        '110': '110',
        '120': '120',
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-out',
        'fade-in-up': 'fadeInUp 0.4s ease-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
        'slide-in-right': 'slideInRight 0.3s ease-out',
        'slide-in-left': 'slideInLeft 0.3s ease-out',
        'scale-in': 'scaleIn 0.2s ease-out',
        'bounce-slow': 'bounce 2s infinite',
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        'printer': 'printer 2s ease-in-out infinite',
        'rotate-cmyk': 'rotateCMYK 10s linear infinite',
        'shimmer': 'shimmer 2s infinite',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(30px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideDown: {
          '0%': { transform: 'translateY(-20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideInRight: {
          '0%': { transform: 'translateX(100%)', opacity: '0' },
          '100%': { transform: 'translateX(0)', opacity: '1' },
        },
        slideInLeft: {
          '0%': { transform: 'translateX(-100%)', opacity: '0' },
          '100%': { transform: 'translateX(0)', opacity: '1' },
        },
        scaleIn: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
        printer: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-5px)' },
        },
        rotateCMYK: {
          '0%': { 
            'background-position': '0% 0%',
            'background-image': 'linear-gradient(135deg, #00aeef 0%, #ec008c 25%, #fff200 50%, #231f20 100%)'
          },
          '100%': { 
            'background-position': '400% 0%',
            'background-image': 'linear-gradient(135deg, #231f20 0%, #fff200 25%, #ec008c 50%, #00aeef 100%)'
          },
        },
        shimmer: {
          '0%': { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
        
      },
      spacing: {
        '128': '32rem',
        '144': '36rem',
        '192': '48rem',
        '256': '64rem',
      },
      borderRadius: {
        'xl': '1rem',
        '2xl': '1.5rem',
        '3xl': '2rem',
      },
      backgroundColor: {
        'page': '#f8fafc',
        'card': '#ffffff',
        'muted': '#f1f5f9',
      },
      // Custom typography untuk digital printing
      typography: (theme) => ({
        DEFAULT: {
          css: {
            color: theme('colors.neutral.800'),
            a: {
              color: theme('colors.primary.600'),
              '&:hover': {
                color: theme('colors.primary.700'),
              },
            },
          },
        },
      }),
      // Custom utilities untuk printing
      borderWidth: {
        '3': '3px',
        '5': '5px',
      },
      // Responsive breakpoints khusus untuk preview cetak
      screens: {
        'print': {'raw': 'print'},
        'xs': '475px',
        '3xl': '1920px',
        '4k': '3840px',
      },
      // Grid untuk layout produk
      gridTemplateColumns: {
        'print-layout': 'repeat(auto-fill, minmax(300px, 1fr))',
        'product-grid': 'repeat(auto-fit, minmax(280px, 1fr))',
        'complex': 'repeat(12, 1fr)',
      },
      // Opacity khusus untuk overlay
      opacity: {
        '15': '0.15',
        '35': '0.35',
        '65': '0.65',
        '85': '0.85',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/aspect-ratio'),
  ],
  
}

