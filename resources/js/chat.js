import { format } from "date-fns";

function chatBox(config) {
    return {
        authUserId: config.authUserId,
        chatId: config.chatId,
        messages: config.initialMessages,
        newContent: "",
        otherUser: config.otherUser,

        init() {
            // Inisialisasi status pesan saat pertama kali dimuat
            this.messages = this.messages.map((message) => ({
                ...message,
                status: message.read_at ? "read" : "sent",
            }));

            this.scrollToBottom();
            this.markMessagesAsRead();

            // Mendengarkan event 'MessageSent' dari backend
            Echo.private(`chat.${this.chatId}`)
                .listen("MessageSent", (e) => { // ✅ Sudah benar, sesuai broadcastAs() di backend
                    // Cek jika pesan berasal dari user lain, bukan dari diri sendiri
                    // Mengakses properti langsung dari event (e.id, e.sender_id)
                    if (e.sender_id !== this.authUserId) {
                        this.messages.push({
                            id: e.id,
                            chat_id: e.chat_id,
                            sender_id: e.sender_id,
                            content: e.content,
                            created_at: e.created_at, // Menggunakan data dari backend
                            status: "sent",
                        });
                        this.scrollToBottom();
                        this.markMessagesAsRead();
                    }
                })
                // Menunggu event 'ReadMessage' untuk menandai pesan terbaca
                .listen("ReadMessage", (e) => {
                    const messageIndex = this.messages.findIndex(
                        (m) => m.id === e.message.id
                    );
                    if (messageIndex > -1) {
                        this.messages[messageIndex].status = "read";
                    }
                });
        },

        // Fungsi BARU untuk memanggil API markAsRead
        markMessagesAsRead() {
            // Menggunakan fetch untuk POST ke endpoint markAsRead
            fetch(`/chat/${this.chatId}/read`, { // ✅ Periksa rute di web.php
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            }).catch((err) => console.error("Gagal menandai pesan:", err));
        },

        sendMessage() {
            if (this.newContent.trim() === "") return;
            const tempId = Date.now();
            const messageToSend = this.newContent;

            // Tambahkan pesan sementara ke UI
            this.messages.push({
                id: tempId,
                sender_id: this.authUserId,
                content: messageToSend,
                created_at: new Date().toISOString(),
                status: "sending",
            });

            this.newContent = "";
            this.scrollToBottom();

            // Kirim pesan ke backend via fetch (AJAX)
            fetch(`/chat/${this.chatId}/send`, { // ✅ Pastikan ini sesuai dengan rute di web.php
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({ content: messageToSend }),
            })
                .then((response) => response.json())
                .then((serverMessage) => {
                    // Temukan pesan sementara dan ganti dengan data dari server
                    const messageIndex = this.messages.findIndex(
                        (m) => m.id === tempId
                    );
                    if (messageIndex > -1) {
                        this.messages[messageIndex] = {
                            ...serverMessage.message, // ✅ Mengakses properti 'message' di JSON
                            status: "sent",
                        };
                    }
                })
                .catch((err) => {
                    console.error("Gagal mengirim pesan:", err);
                    // Tandai pesan gagal jika ada error
                    const messageIndex = this.messages.findIndex(
                        (m) => m.id === tempId
                    );
                    if (messageIndex > -1) {
                        this.messages[messageIndex].status = "failed";
                    }
                });
        },

        scrollToBottom() {
            this.$nextTick(() => {
                this.$refs.messagesContainer.scrollTop =
                    this.$refs.messagesContainer.scrollHeight;
            });
        },

        formatTime(timestamp) {
            return format(new Date(timestamp), "HH:mm");
        },
    };
}

window.chatBox = chatBox;
