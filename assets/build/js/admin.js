console.log("talent-portal admin.js loaded");(function(t){t("table.wp-list-table.applications").on("click","a.submitdelete",function(n){if(n.preventDefault(),!confirm(talentPortal.confirm))return;const e=t(this),o=e.data("id");wp.ajax.post("talent-portal-delete",{id:o,_wpnonce:talentPortal.nonce}).done(function(l){e.closest("tr").css("background-color","red").hide(400,function(){t(this).remove()})}).fail(function(){alert(talentPortal.error)})})})(jQuery);
