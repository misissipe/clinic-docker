@if(session('employee_id') && in_array(session('role'), ['Admin', 'Super Admin', 'Doctor', 'Nurse', 'Nurse Attendant', 'Dentist', 'Attendant']))
<li class="dropdown dropdown-notification nav-item" id="clinicNotificationBell">
  <a href="#" role="button" class="nav-link nav-link-label position-relative" data-toggle="dropdown" aria-label="Notifications" aria-haspopup="true" aria-expanded="false">
    <i class="ficon bx bx-bell"></i><span id="clinicUnread" class="badge badge-pill badge-danger badge-up" hidden></span>
  </a>
  <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
    <li class="dropdown-menu-header">
      <div class="dropdown-header px-1 py-75 d-flex justify-content-between align-items-center">
        <span class="notification-title" id="clinicNotificationTitle">Notifications</span>
        <button type="button" class="border-0 bg-transparent text-white text-bold-400 cursor-pointer" id="clinicReadAll">Mark all as read</button>
      </div>
    </li>
    <li class="scrollable-container media-list" id="clinicNotificationList" aria-live="polite"><p class="px-1">Loading notifications…</p></li>
  </ul>
</li>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var base = @json(url('/clinic-notifications'));
  var list = document.getElementById('clinicNotificationList');
  var badge = document.getElementById('clinicUnread');
  var busy = false;
  function post(path) {
    return fetch(path, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' } })
      .then(function (response) { if (!response.ok) throw new Error('Unable to update notification'); return response.json(); });
  }
  function refresh() {
    if (busy) return;
    busy = true;
    fetch(base, { headers: { 'Accept': 'application/json' }, cache: 'no-store' })
      .then(function (response) { if (!response.ok) throw new Error('Unable to load notifications'); return response.json(); })
      .then(function (data) {
        badge.hidden = !data.unread;
        badge.textContent = data.unread > 99 ? '99+' : data.unread;
        document.getElementById('clinicNotificationTitle').textContent = data.unread ? data.unread + ' unread notifications' : 'Notifications';
        list.replaceChildren();
        if (!data.items.length) { var empty = document.createElement('p'); empty.className = 'px-1 text-muted'; empty.textContent = 'No notifications yet.'; list.appendChild(empty); }
        data.items.forEach(function (item) {
          var button = document.createElement('button');
          button.type = 'button';
          button.className = 'd-flex w-100 text-left border-0 bg-transparent justify-content-between' + (item.read_at ? ' read-notification' : '');
          var media = document.createElement('div'); media.className = 'media d-flex align-items-center';
          var iconWrap = document.createElement('div'); iconWrap.className = 'media-left pr-0';
          var icon = document.createElement('i'); icon.className = 'bx bx-bell primary mr-1'; icon.setAttribute('aria-hidden', 'true'); iconWrap.appendChild(icon);
          var body = document.createElement('div'); body.className = 'media-body';
          var message = document.createElement('h6'); message.className = 'media-heading' + (item.read_at ? '' : ' text-bold-500'); message.textContent = item.message;
          var date = document.createElement('small'); date.className = 'notification-text'; date.textContent = item.created_at;
          body.appendChild(message); body.appendChild(date); media.appendChild(iconWrap); media.appendChild(body); button.appendChild(media);
          button.addEventListener('click', function () {
            if (item.id === null) { window.location.assign(item.path); return; }
            post(base + '/' + item.id + '/read').then(function (data) { window.location.assign(data.path); }).catch(function () { button.disabled = false; });
            button.disabled = true;
          });
          var row = document.createElement('div'); row.className = 'border-bottom';
          row.appendChild(button);
          list.appendChild(row);
        });
      })
      .catch(function () { if (!list.querySelector('button')) list.textContent = 'Notifications are temporarily unavailable.'; })
      .finally(function () { busy = false; });
  }
  document.getElementById('clinicReadAll').addEventListener('click', function (event) { event.stopPropagation(); post(base + '/read-all').then(refresh).catch(function () {}); });
  refresh();
  setInterval(function () { if (!document.hidden) refresh(); }, 30000);
});
</script>
@endif
