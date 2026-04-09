<div class="page-default">
    @extends('layout.page')
</div>

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Orbitron:wght@700;900&display=swap');

  /* ══════════════════════════════════════════
     ROOT VARIABLES — Light Theme
  ══════════════════════════════════════════ */
  :root {
    --purple:     #7B2FBE;
    --purple-lt:  #9D50E0;
    --purple-pale:#f3eafd;
    --green:      #1DB954;
    --green-pale: #e6f9ed;
    --bg:         white;
    --surface:    #ffffff;
    --surface2:   #f0f1f8;
    --border:     rgba(123,47,190,.15);
    --text-dark:  #1a1a2e;
    --text-mid:   #4a4a6a;
    --text-light: #8888aa;
  }

  /* ══════════════════════════════════════════
     SPLASH — light version
  ══════════════════════════════════════════ */
  #splash-area {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 0 20px;
        background: var(--bg) !important;
        border-radius: 12px;
        font-family: 'Share Tech Mono', monospace;
        width: 100%;
        min-height: 100vh;
        overflow: hidden;
        position: relative;
        transition: opacity 0.55s ease, max-height 0.55s ease;
        margin-top: -150px;
    }
  #splash-area.sp-hide {
  opacity: 0;
  pointer-events: none;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 10;
  transition: opacity 0.55s ease, transform 0.55s ease;
  transform: translateY(-100%);
}

  /* Glow background — soft on white */
  #splash-area::before {
    content: '';
    position: absolute; inset: 0;
    background-image:
      radial-gradient(circle at 20% 30%, rgba(123,47,190,.07) 0%, transparent 55%),
      radial-gradient(circle at 80% 70%, rgba(29,185,84,.06) 0%, transparent 55%);
    pointer-events: none;
    animation: spBgPulse 6s ease-in-out infinite alternate;
  }
  @keyframes spBgPulse { 0%{opacity:.5} 100%{opacity:1} }

  /* ── Logo Card — light ── */
  .sp-card {
    position: relative;
    background: var(--surface);
    border-radius: 20px;
    padding: 100px 800px 100px 100px;
    display: flex;
    align-items: center;
    gap: 36px;
    border: 1px solid var(--border);
    box-shadow:
      0 4px 40px rgba(123,47,190,.10),
      0 2px 12px rgba(29,185,84,.06),
      0 1px 0 rgba(255,255,255,.9) inset;
    width: min(820px, 92%);
    overflow: hidden;
    animation: spCardReveal 1s cubic-bezier(.22,1,.36,1) both;
}
  @keyframes spCardReveal {
    from { opacity:0; transform:translateY(30px) scale(.97); }
    to   { opacity:1; transform:translateY(0)    scale(1); }
  }

  /* animated gradient border */
  .sp-card::before {
    content: '';
    position: absolute; inset: -2px; border-radius: 22px;
    background: linear-gradient(90deg, #7B2FBE, #1DB954, #7B2FBE);
    background-size: 300% 100%;
    animation: spBorder 4s linear infinite;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor; mask-composite: exclude;
    padding: 3px; /* sebelumnya 1px */
    opacity: .45;
}
  @keyframes spBorder { 0%{background-position:0% 50%} 100%{background-position:300% 50%} }

  /* dot grid — very subtle on white */
  .sp-card::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
      radial-gradient(circle, rgba(123,47,190,.05) 1px, transparent 1px),
      radial-gradient(circle, rgba(29,185,84,.05)  1px, transparent 1px);
    background-size: 30px 30px, 30px 30px;
    background-position: 0 0, 15px 15px;
    border-radius: 20px; pointer-events: none;
  }

  /* Corner accents */
  .sp-c { position:absolute; width:16px; height:16px; z-index:3; }
  .sp-c.tl { top:12px; left:12px;   border-top:2px solid #7B2FBE; border-left:2px solid #7B2FBE; }
  .sp-c.tr { top:12px; right:12px;  border-top:2px solid #1DB954; border-right:2px solid #1DB954; }
  .sp-c.bl { bottom:12px; left:12px;  border-bottom:2px solid #1DB954; border-left:2px solid #1DB954; }
  .sp-c.br { bottom:12px; right:12px; border-bottom:2px solid #7B2FBE; border-right:2px solid #7B2FBE; }

  /* Icon hex */
  .sp-icon {
        position: relative;
        width: 150px;
        height: 150px;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: spCardReveal 1s cubic-bezier(.22,1,.36,1) both;
    }
  .sp-hex  { width:100%; height:100%;
    filter: drop-shadow(0 0 10px rgba(123,47,190,.35)) drop-shadow(0 0 20px rgba(29,185,84,.2)); margin-top:20px }
  .sp-orbit {
    position:absolute; inset:-15px; border-radius:50%;
    border:2px dashed rgb(73, 255, 67);
    animation:spSpin 8s linear infinite;
  }
  @keyframes spSpin { to{transform:rotate(360deg)} }
  .sp-dot {
    position:absolute; top:8px; left:50%; transform:translateX(-50%);
    width:6px; height:6px; border-radius:50%; background:#1DB954;
    box-shadow:0 0 8px #1DB954, 0 0 16px rgba(29,185,84,.4);
  }

  /* Text */
  .sp-text {
        position: relative;
        z-index: 2;
        text-align: center;
        animation: spFadeUp 1s .3s both;
    }
  .sp-brand {
    font-family: 'Orbitron', sans-serif;
    font-size: 130px;
    font-weight: 900;
    letter-spacing: 5px;
    line-height: 1;
    background: linear-gradient(90deg,#7B2FBE 0%,#5B4FD9 45%,#1DB954 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: spTextPulse 3s ease-in-out infinite;
}

  @keyframes spTextPulse {
    0%,100%{filter:drop-shadow(0 0 8px rgba(123,47,190,.25))}
    50%    {filter:drop-shadow(0 0 16px rgba(29,185,84,.3))}
  }
  .sp-line {
    height:2px; background:linear-gradient(90deg,#7B2FBE,#1DB954,transparent);
    margin:10px 0; border-radius:2px; position:relative; overflow:hidden;
  }
  .sp-line::after {
    content:''; position:absolute; left:-100%; top:0; height:100%; width:60%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.8),transparent);
    animation:spShimmer 2.5s ease-in-out infinite;
  }
  @keyframes spShimmer { 0%{left:-100%} 100%{left:200%} }
  .sp-tagline { font-size:10px; letter-spacing:3px; color:var(--text-light); margin-bottom:6px; text-transform:uppercase; }
  .sp-hospital {
    font-size:11px; letter-spacing:2px; text-transform:uppercase;
    background:linear-gradient(90deg,#7B2FBE,#1DB954);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
  }
  .sp-badge {
    display:inline-flex; align-items:center; gap:8px; margin-top:12px;
    padding:5px 12px; border:1px solid rgba(123,47,190,.25); border-radius:4px;
    background: var(--purple-pale);
    font-size:8.5px; letter-spacing:2px; color:#7B2FBE; text-transform:uppercase;
  }
  .sp-bdot {
    width:5px; height:5px; border-radius:50%; background:#1DB954;
    box-shadow:0 0 6px #1DB954; animation:spBlink 1.5s ease-in-out infinite;
  }
  @keyframes spBlink { 0%,100%{opacity:1} 50%{opacity:.2} }
  .sp-ekg { position:absolute; bottom:18px; right:24px; opacity:.25; z-index:2; }

  .sp-footer {
        position: absolute;
        bottom: 30px;
        left: 100px;
        right: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        animation: spFadeUp 1s .4s both;
    }

    .sp-footer .sp-txt {
        font-size: 10px;
        letter-spacing: 2px;
        color: var(--text-light);
        text-transform: uppercase;
        text-align: center;
        white-space: nowrap;
    }
  @keyframes spFadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
  .sp-row { display:flex; align-items:center; gap:20px; }
  .sp-txt { font-size:10px; letter-spacing:2px; color:var(--text-light); text-transform:uppercase; }

  /* ══════════════════════════════════════════
     DASHBOARD — light theme override
  ══════════════════════════════════════════ */
  .dashboard-page {
    background: var(--bg) !important;
    padding-top: 80px;
    min-height: 100vh;
    position: relative;

  }
  .dashboard-page .container-fluid {
    background: var(--bg) !important;
  }
  #dashboard-content {
    padding-top: 120px !important;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.4s ease, transform 0.4s ease;
    position: relative;
    z-index: 1;
    margin-top: 0 !important;
    }

  /* Stat cards */
  .card-animate {
    opacity: 0;
    transform: translateY(14px);
    background: var(--surface) !important;
    border: 1px solid rgba(123,47,190,.10) !important;
    border-radius: 12px !important;
    transition: box-shadow .25s, transform .25s;
    box-shadow: 0 2px 12px rgba(123,47,190,.07) !important;
  }
  .card-animate.visible {
    animation: dbCardIn .4s forwards;
  }
  @keyframes dbCardIn { to { opacity:1; transform:translateY(0); } }
  .card-animate:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 10px 32px rgba(123,47,190,.14) !important;
  }

  /* Override border-left colors to match light palette */
  .border-left-primary { border-left: 4px solid #7B2FBE !important; }
  .border-left-success { border-left: 4px solid #1DB954 !important; }
  .border-left-info    { border-left: 4px solid #5B4FD9 !important; }
  .border-left-warning { border-left: 4px solid #9D50E0 !important; }

  /* Text overrides */
  .text-primary  { color: #7B2FBE !important; }
  .text-success  { color: #1DB954 !important; }
  .text-info     { color: #5B4FD9 !important; }
  .text-warning  { color: #9D50E0 !important; }

  /* Card label & value */
  .card-body .text-xs { color: var(--text-mid) !important; }
  .card-body .h5      { color: var(--text-dark) !important; }

  /* Icon color in cards */
  .card-body .text-black-300 { color: rgba(123,47,190,.25) !important; }

  /* Chip label for each card type */
  .card-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 8px;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 2px 8px;
    border-radius: 20px;
    margin-bottom: 4px;
    font-family: 'Share Tech Mono', monospace;
  }
  .chip-purple { background: var(--purple-pale); color: var(--purple); }
  .chip-green  { background: var(--green-pale);  color: var(--green); }
  .chip-indigo { background: #eeecfd; color: #5B4FD9; }
  .chip-violet { background: #f5eaff; color: #9D50E0; }

   @media screen and (max-width: 768px) {

    /* SPLASH — Mobile Optimized */
    #splash-area {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 20px;
      padding: 40px 20px;
      background: var(--bg) !important;
      border-radius: 0;
      font-family: 'Share Tech Mono', monospace;
      width: 100%;
      min-height: 100vh;
      overflow: hidden;
      position: relative;
      transition: opacity 0.55s ease;
      margin-top: 0;
    }

    #splash-area.sp-hide {
      opacity: 0;
      pointer-events: none;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 10;
      transition: opacity 0.55s ease;
      transform: translateY(-100%);
    }

    /* Logo Card — Mobile */
    .sp-card {
      position: relative;
      background: var(--surface);
      border-radius: 20px;
      padding: 60px 20px 60px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 24px;
      border: 1px solid var(--border);
      box-shadow:
        0 8px 40px rgba(123,47,190,.12),
        0 4px 20px rgba(29,185,84,.08),
        0 2px 0 rgba(255,255,255,.95) inset;
      width: 100%;
      max-width: 360px;
      overflow: hidden;
      animation: spCardReveal 1s cubic-bezier(.22,1,.36,1) both;
    }

    /* Icon hex — Mobile */
    .sp-icon {
      position: relative;
      width: 120px;
      height: 120px;
      z-index: 2;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: spCardReveal 1s cubic-bezier(.22,1,.36,1) both;
    }
    .sp-hex {
      width:100%;
      height:100%;
      filter: drop-shadow(0 0 12px rgba(123,47,190,.4)) drop-shadow(0 0 24px rgba(29,185,84,.25));
    }

    /* Text — Mobile */
    .sp-text {
      position: relative;
      z-index: 2;
      text-align: center;
      animation: spFadeUp 1s .3s both;
      width: 100%;
    }
    .sp-brand {
      font-family: 'Orbitron', sans-serif;
      font-size: 48px;
      font-weight: 900;
      letter-spacing: 2px;
      line-height: 1;
      background: linear-gradient(90deg,#7B2FBE 0%,#5B4FD9 45%,#1DB954 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: spTextPulse 3s ease-in-out infinite;
    }

    .sp-line {
      height: 2px;
      background: linear-gradient(90deg,#7B2FBE,#1DB954,transparent);
      margin: 12px auto;
      width: 80px;
      border-radius: 2px;
      position: relative;
      overflow: hidden;
    }

    .sp-tagline {
      font-size: 12px;
      letter-spacing: 1.5px;
      color: var(--text-light);
      margin-bottom: 8px;
      text-transform: uppercase;
    }

    .sp-hospital {
      font-size: 13px;
      letter-spacing: 1px;
      text-transform: uppercase;
      background: linear-gradient(90deg,#7B2FBE,#1DB954);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .sp-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: 12px;
      padding: 6px 12px;
      border: 1px solid rgba(123,47,190,.3);
      border-radius: 20px;
      background: var(--purple-pale);
      font-size: 10px;
      letter-spacing: 1px;
      color: #7B2FBE;
      text-transform: uppercase;
    }

    .sp-bdot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: #1DB954;
      box-shadow: 0 0 8px #1DB954;
      animation: spBlink 1.5s ease-in-out infinite;
    }

    .sp-ekg {
      position: absolute;
      bottom: 20px;
      right: 20px;
      opacity: .3;
      z-index: 2;
    }

    /* Footer — Mobile */
    .sp-footer {
      position: absolute;
      bottom: 20px;
      left: 20px;
      right: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 6px;
      animation: spFadeUp 1s .4s both;
    }
    .sp-footer .sp-txt {
      font-size: 9px;
      letter-spacing: 1px;
      color: var(--text-light);
      text-transform: uppercase;
      text-align: center;
    }

    /* DASHBOARD — Mobile */
    .dashboard-page {
      background: var(--bg) !important;
      padding-top: 0;
      min-height: 100vh;
      position: relative;
    }

    #dashboard-content {
      padding-top: 20px !important;
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.4s ease, transform 0.4s ease;
      position: relative;
      z-index: 1;
      margin-top: 0 !important;
      padding: 20px;
    }

    /* Stat cards — Mobile */
    .card-animate {
      opacity: 0;
      transform: translateY(14px);
      background: var(--surface) !important;
      border: 1px solid rgba(123,47,190,.12) !important;
      border-radius: 16px !important;
      transition: all .3s ease;
      box-shadow: 0 4px 20px rgba(123,47,190,.08) !important;
      margin-bottom: 16px !important;
    }

    .card-animate.visible {
      animation: dbCardIn .4s forwards;
    }

    .card-animate:hover {
      transform: translateY(-2px) !important;
      box-shadow: 0 12px 40px rgba(123,47,190,.16) !important;
    }

    /* Card content — Mobile */
    .card-body {
      padding: 20px !important;
    }

    .card-body .text-xs {
      font-size: 11px !important;
      color: var(--text-mid) !important;
      margin-bottom: 4px !important;
    }

    .card-body .h5 {
      font-size: 28px !important;
      color: var(--text-dark) !important;
      font-weight: 800 !important;
    }

    /* Grid — Mobile Single Column */
    .row {
      margin: 0 -8px;
    }
    .col-xl-3, .col-md-6 {
      padding: 0 8px;
      flex: 0 0 100%;
      max-width: 100%;
    }

    /* Chip labels — Mobile */
    .card-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 9px;
      letter-spacing: 1px;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: 20px;
      margin-bottom: 8px;
      font-family: 'Share Tech Mono', monospace;
    }

    /* Icons — Mobile */
    .col-auto i {
      font-size: 2.2em !important;
    }
  }
</style>

<div class="dashboard-page">

{{-- ════════════════ SPLASH ════════════════ --}}
<div id="splash-area">
    <div class="sp-icon">
      <div class="sp-orbit"><div class="sp-dot"></div></div>
      <svg class="sp-hex" viewBox="0 0 120 138" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <linearGradient id="hg1" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%"   stop-color="#7B2FBE"/>
            <stop offset="50%"  stop-color="#5B4FD9"/>
            <stop offset="100%" stop-color="#1DB954"/>
          </linearGradient>
          <linearGradient id="hg2" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%"   stop-color="#9D50E0" stop-opacity=".12"/>
            <stop offset="100%" stop-color="#1DB954"  stop-opacity=".12"/>
          </linearGradient>
          <linearGradient id="gg1" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%"   stop-color="#1DB954"/>
            <stop offset="100%" stop-color="#7B2FBE"/>
          </linearGradient>
          <filter id="fg">
            <feGaussianBlur stdDeviation="2" result="b"/>
            <feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge>
          </filter>
        </defs>
        <polygon points="60,2 110,30 110,86 60,114 10,86 10,30"  fill="url(#hg2)" stroke="url(#hg1)" stroke-width="2"/>
        <polygon points="60,12 100,35 100,81 60,104 20,81 20,35" fill="none" stroke="url(#hg1)" stroke-width="1" opacity=".35"/>
        <polygon points="60,20 94,40 94,80 60,100 26,80 26,40"   fill="url(#hg1)" opacity=".92"/>
        <rect x="47"   y="55" width="26" height="9"  rx="2.5" fill="white" filter="url(#fg)"/>
        <rect x="55.5" y="46" width="9"  height="27" rx="2.5" fill="white" filter="url(#fg)"/>
        <g transform="translate(90,98)">
          <circle cx="0" cy="0" r="10" fill="#f5f6fa" stroke="url(#gg1)" stroke-width="2"/>
          <circle cx="0" cy="0" r="4.5" fill="none"  stroke="url(#gg1)" stroke-width="1.5"/>
          <rect x="-2" y="-13" width="4" height="5" rx="1" fill="url(#gg1)"/>
          <rect x="-2" y="8"   width="4" height="5" rx="1" fill="url(#gg1)"/>
          <rect x="8"  y="-2"  width="5" height="4" rx="1" fill="url(#gg1)"/>
          <rect x="-13" y="-2" width="5" height="4" rx="1" fill="url(#gg1)"/>
          <rect x="7"  y="-12" width="4" height="5" rx="1" fill="url(#gg1)" transform="rotate(45 5.5 -10.5)"/>
          <rect x="-12" y="-9.5" width="4" height="5" rx="1" fill="url(#gg1)" transform="rotate(-45 -9.5 -10.5)"/>
          <rect x="3.5"  y="5.5"   width="4" height="5" rx="1" fill="url(#gg1)" transform="rotate(-45 5.5 5.5)"/>
          <rect x="-8" y="3"   width="4" height="5" rx="1" fill="url(#gg1)" transform="rotate(45 -9.5 5.5)"/>
        </g>
        <g transform="translate(30,98)">
          <rect x="-10" y="-10" width="20" height="20" rx="2.5" fill="#f5f6fa" stroke="url(#hg1)" stroke-width="1.5"/>
          <rect x="-6"  y="-10" width="12" height="5"  rx="1"   fill="url(#hg1)"/>
          <line x1="-6" y1="-1" x2="6"  y2="-1" stroke="url(#hg1)" stroke-width="1.2"/>
          <line x1="-6" y1="3"  x2="2"  y2="3"  stroke="url(#hg1)" stroke-width="1.2"/>
          <line x1="-6" y1="7"  x2="4"  y2="7"  stroke="url(#hg1)" stroke-width="1.2"/>
        </g>
        <line x1="42" y1="98" x2="78" y2="98" stroke="url(#hg1)" stroke-width="1" opacity=".3" stroke-dasharray="3,3"/>
      </svg>
    </div>

    <div class="sp-text">
      <div class="sp-brand">SIMANTIS</div>
      <div class="sp-line"></div>
      <div class="sp-tagline">Sistem Maintenance dan Inventaris</div>
      <div class="sp-hospital">RS Darmayu · Madiun</div>
      <div class="sp-badge">
        <div class="sp-bdot"></div>
        Health Asset Management System
      </div>
    </div>

    <div class="sp-ekg">
      <svg width="80" height="30" viewBox="0 0 80 30">
        <polyline points="0,15 10,15 14,5 18,25 22,2 26,28 32,15 80,15"
          fill="none" stroke="#1DB954" stroke-width="1.5"/>
      </svg>
    </div>
  </div>

  <div class="sp-footer">
    <div class="sp-row">
    </div>

</div>{{-- /#splash-area --}}
{{-- ════════════════ DASHBOARD ════════════════ --}}
<div id="dashboard-content">
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 card-animate">
            <div class="card-body">
                @php
                    $user = DB::table('users')->get();
                @endphp
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Users</div>
                        <div class="h5 mb-0 font-weight-bold text-black-800">{{ $user->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 card-animate">
            <div class="card-body">
                @php
                    $perangkat = DB::table('perangkat as a')->join('kategori_perangkat as b','a.id_kategori','b.id_kategori')->get();
                @endphp
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Perangkat</div>
                        <div class="h5 mb-0 font-weight-bold text-black-800">{{ $perangkat->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-laptop fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 card-animate">
            <div class="card-body">
                @php
                    $maintenance = DB::table('maintenance')->distinct()->count('id_ruangan');
                @endphp
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Maintenance</div>
                        <div class="h5 mb-0 font-weight-bold text-black-800">{{ $maintenance }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tools fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 card-animate">
            <div class="card-body">
                @php
                    $ruangan = DB::table('ruangan')->get();
                @endphp
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ruangan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ruangan->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hospital fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>{{-- /row --}}
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
(function () {
  'use strict';

  document.addEventListener("DOMContentLoaded", function () {
    var splash = document.getElementById('splash-area');
    var dashboard = document.getElementById('dashboard-content');

    window.addEventListener('scroll', function () {
      var scrollY = window.scrollY || window.pageYOffset;

      if (scrollY > 80) {
        splash.classList.add('sp-hide');
        dashboard.style.opacity = '1';  // ← GANTI display: block
        dashboard.style.transform = 'translateY(0)';
        dashboard.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        animateCards();
      } else {
        splash.classList.remove('sp-hide');
        dashboard.style.opacity = '0';
        dashboard.style.transform = 'translateY(20px)';
      }
    });
  });

  var done = false;
  function animateCards() {
    if (done) return;
    done = true;
    document.querySelectorAll('.card-animate').forEach(function (el, i) {
      setTimeout(function () { el.classList.add('visible'); }, i * 45);
    });
  }
})();
</script>

@endsection
