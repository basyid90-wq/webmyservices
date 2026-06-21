const loaded = {}

function loadScript(src, id) {
  if (loaded[id]) return
  loaded[id] = true
  const script = document.createElement('script')
  script.src = src
  script.async = true
  script.id = id
  document.head.appendChild(script)
}

function loadGTMInline(id) {
  if (loaded['gtm']) return
  loaded['gtm'] = true
  const script = document.createElement('script')
  script.textContent = `(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','${id}');`
  document.head.appendChild(script)
}

function loadMetaPixel(id) {
  if (loaded['meta-pixel']) return
  loaded['meta-pixel'] = true
  const script = document.createElement('script')
  script.textContent = `!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','${id}');fbq('track','PageView');`
  document.head.appendChild(script)
}

export function initGTM(id) {
  if (!id || id === 'GTM-XXXXXXX') return
  loadScript(`https://www.googletagmanager.com/gtag/js?id=${id}`, 'gtag')
  loadGTMInline(id)
}

export function initMetaPixel(id) {
  if (!id || id === 'PIXEL-XXXXXXX') return
  loadMetaPixel(id)
}

export function initAnalytics({ gtmId, pixelId }) {
  initGTM(gtmId)
  initMetaPixel(pixelId)
}
