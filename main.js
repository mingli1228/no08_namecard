const firebaseConfig = {};

firebase.initializeApp(firebaseConfig);
const db = firebase.database();

$("#toRegister").click(() => {
  $("#register").show();
  $("#list").hide();
});

$("#toList").click(() => {
  $("#register").hide();
  $("#list").empty().show();
  db.ref("meishi")
    .orderByChild("timestamp")
    .once("value", (snapshot) => {
      snapshot.forEach((child) => {
        const d = child.val();
        const html = `
    <div class="card">
      <h3>${d.name}</h3>
      <p>読み方：${d.reading || "なし"}</p>
      <p>会社名：${d.company || "なし"}</p>
      <p>あった日：${d.date || "未記入"}</p>
      ${d.note ? `<p>メモ：${d.note}</p>` : ""}
      ${
        d.twitter
          ? `<a href="https://twitter.com/${d.twitter}" target="_blank">Twitter</a>`
          : ""
      }
      ${
        d.facebook
          ? `<a href="https://facebook.com/${d.facebook}" target="_blank">Facebook</a>`
          : ""
      }
      ${
        d.instagram
          ? `<a href="https://instagram.com/${d.instagram}" target="_blank">Instagram</a>`
          : ""
      }
      ${
        d.tiktok
          ? `<a href="https://www.tiktok.com/@${d.tiktok}" target="_blank">TikTok</a>`
          : ""
      }
      ${
        d.linkedin
          ? `<a href="https://www.linkedin.com/in/${d.linkedin}" target="_blank">LinkedIn</a>`
          : ""
      }
    </div>`;
        $("#list").append(html);
      });
    });
});

$("#submit").click(() => {
  const data = {
    name: $("#name").val(),
    reading: $("#reading").val(),
    company: $("#company").val(),
    date: $("#date").val(),
    twitter: $("#twitter").val(),
    facebook: $("#facebook").val(),
    instagram: $("#instagram").val(),
    tiktok: $("#tiktok").val(),
    linkedin: $("#linkedin").val(),
    note: $("#note").val(),
    timestamp: Date.now(),
  };

  if (!data.name) {
    alert("名前は必須です");
    return;
  }

  db.ref("meishi").push(data);
  alert("登録完了！");
  $("input, textarea").val("");
});
