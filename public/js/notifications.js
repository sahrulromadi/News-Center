function fetchNotifications() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/notifications/fetch', true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                displayNotifications(response.notifications);
            } else {
                console.error('Failed to fetch notifications. Status:', xhr.status);
            }
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send();
}

function displayNotifications(notifications) {
    var notificationsContainer = document.getElementById('notifications-container');

    if (notificationsContainer) {
        notificationsContainer.innerHTML = '';
            notifications.forEach(function(notification) {
                var notificationElement = document.createElement('a');
                notificationElement.href = '#';
                notificationElement.className = '' + (notification.read_at ? 'text-dark' : 'bg-black text-light');
                notificationElement.onclick = function() {
                    markNotificationAsRead(notification.id);
                    return false;
                };

                var iconElement = document.createElement('div');
                iconElement.className = 'notif-icon notif-success';
                iconElement.innerHTML = '<i class="fa fa-comment"></i>';

                var contentElement = document.createElement('div');
                contentElement.className = 'notif-content';

                function timeAgo(timestamp) {
                    const date = new Date(timestamp);
                    const now = new Date();
                    const seconds = Math.floor((now - date) / 1000);

                    let interval = Math.floor(seconds / 31536000);

                    if (interval > 1) {
                        return interval + " years ago";
                    }
                    interval = Math.floor(seconds / 2592000);
                    if (interval > 1) {
                        return interval + " months ago";
                    }
                    interval = Math.floor(seconds / 86400);
                    if (interval > 1) {
                        return interval + " days ago";
                    }
                    interval = Math.floor(seconds / 3600);
                    if (interval > 1) {
                        return interval + " hours ago";
                    }
                    interval = Math.floor(seconds / 60);
                    if (interval > 1) {
                        return interval + " minutes ago";
                    }
                    return Math.floor(seconds) + " seconds ago";
                }

                var timeAgoString = timeAgo(notification.created_at);

                contentElement.innerHTML = '<span class="block text-wrap">' + notification.data + '</span>' + '<span class="time text-wrap">' + timeAgoString + '</span>';

                notificationElement.appendChild(iconElement);
                notificationElement.appendChild(contentElement);

                notificationsContainer.appendChild(notificationElement);
            });
    } else {
        //
    }
}

function markNotificationAsRead(notificationId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/notifications/' + notificationId + '/read', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    
    var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    console.log('Notification marked as read successfully');
                    fetchUnreadNotificationsCount();
                    fetchNotifications(); 
                } else {
                    console.error('Failed to mark notification as read:', response.message);
                }
            } else {
                console.error('Failed to mark notification as read. Status:', xhr.status);
            }
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send();
}

function fetchUnreadNotificationsCount() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/notifications/count', true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                updateUnreadNotificationsCount(response.unreadCount);
            } else {
                console.error('Failed to fetch unread notifications count. Status:', xhr.status);
            }
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send();
}

function updateUnreadNotificationsCount(count) {
    var unreadCountElement = document.getElementById('unread-notification-count');
    if (unreadCountElement) {
        unreadCountElement.textContent = count.toString();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    fetchUnreadNotificationsCount();
    fetchNotifications();
});
