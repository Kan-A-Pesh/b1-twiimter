const postModalExist = () => {
    return document.querySelector(".post-form") != null;
};

if (postModalExist())
{
    const postModal = document.querySelector(".post-form");
    const postModalClose = document.querySelector(".post-form .cancel");

    postModalClose.addEventListener("click", () => {
        postModal.classList.add("hidden");
    });
}

const publish = (replyId) => {
    console.log("publish", replyId, postModalExist());
    if (!postModalExist()) return;

    const postModal = document.querySelector(".post-form");
    const postModalReplyId = document.querySelector(".post-form #reply-id");

    postModalReplyId.value = replyId ?? "";

    postModal.classList.remove("hidden");
};