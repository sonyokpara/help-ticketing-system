# Help Ticketing System

### Project Idea

1. User can create a new help ticket
2. Admin can reply on help ticket
3. Admin can reject or resolve the ticket
4. When Admin update on the ticket status then user will get a notification via email that ticket status is updated
5. User can give ticket title and description
6. User can upload a document like pdf or image

#### Table Structure

1. Tickets
    - title(string) {required}
    - description(text) {required}
    - status(enum, [open {default}, resolved, rejected]) {required}
    - attachments(string) {nullable}
    - user_id(int) {required} filled by Laravel
    - status_changed_by_id(int) {required} filled by laravel

2. Replies 
    - body(text) {required}
    - user_id {required} filled by Laravel
    - ticket_id {required} filled by Laravel
