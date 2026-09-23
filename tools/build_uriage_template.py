# -*- coding: utf-8 -*-
"""売上管理表テンプレートを作る。記事9236の設計（4シート・SUM/SUMIF/AVERAGE）に合わせる。"""
import datetime
from openpyxl import Workbook
from openpyxl.styles import Font, PatternFill, Alignment, Border, Side
from openpyxl.chart import BarChart, LineChart, Reference
from openpyxl.utils import get_column_letter
from openpyxl.comments import Comment

F = "Meiryo"
BLUE  = Font(name=F, size=10, color="0000FF")          # 入力してもらうところ
BLACK = Font(name=F, size=10)                           # 自動計算
HEAD  = Font(name=F, size=10, bold=True, color="FFFFFF")
TITLE = Font(name=F, size=13, bold=True)
NOTE  = Font(name=F, size=9, color="808080")
FILLH = PatternFill("solid", fgColor="4A4A4A")
FILLI = PatternFill("solid", fgColor="FFF9E6")          # 入力欄の下地
THIN  = Side(style="thin", color="D0D0D0")
BOX   = Border(left=THIN, right=THIN, top=THIN, bottom=THIN)

YEN = '#,##0"円";[Red]-#,##0"円";-'
PCT = '0.0%;[Red]-0.0%;-'
NUM = '#,##0;[Red]-#,##0;-'

DAYS = 400         # 日次入力の行数（数式を置く範囲。13か月ぶん入る）
SHOWN = 35         # 下地と罫線を引く行数
MONTHS = 24        # 月次集計の行数（前年同月比を出すため2年ぶん）
ITEMS = 20         # 商品別の行数

wb = Workbook()

# ============================================================
# シート① 日次入力
# ============================================================
s1 = wb.active
s1.title = "日次入力"
s1["A1"] = "売上管理表｜日次入力"; s1["A1"].font = TITLE
s1["A2"] = "青い字のセルに入力してください。黒い字は自動で計算されます。6行目は記入例です。上書きして使ってください。"
s1["A2"].font = NOTE

cols1 = [("日付", 12), ("曜日", 7), ("売上", 13), ("来客数", 9), ("客単価", 12),
         ("時間帯", 11), ("支払方法", 12), ("備考", 30), ("月", 10)]
for i, (name, w) in enumerate(cols1, start=1):
    c = s1.cell(row=4, column=i, value=name)
    c.font = HEAD; c.fill = FILLH; c.alignment = Alignment(horizontal="center")
    s1.column_dimensions[get_column_letter(i)].width = w

s1["I4"].comment = Comment("月次集計シートが SUMIF で使う列。触らないでください。", "テンプレート")

例 = [datetime.date(2026, 10, 1), None, 128000, 42, None, "ランチ", "現金", "雨。来客少なめ", None]
for r in range(5, 5 + DAYS):
    ex = (r == 5)
    s1.cell(row=r, column=1, value=(例[0] if ex else None)).font = BLUE if ex else BLUE
    s1.cell(row=r, column=1).number_format = "yyyy/mm/dd"
    # TEXT(日付,"aaa") は環境の言語で英語（Thu）になる。
    # WEEKDAY+CHOOSE なら、どの環境でも日本語の曜日が出る
    s1.cell(row=r, column=2,
            value=f'=IF($A{r}="","",CHOOSE(WEEKDAY($A{r}),"日","月","火","水","木","金","土"))').font = BLACK
    s1.cell(row=r, column=3, value=(例[2] if ex else None)).font = BLUE
    s1.cell(row=r, column=3).number_format = YEN
    s1.cell(row=r, column=4, value=(例[3] if ex else None)).font = BLUE
    s1.cell(row=r, column=4).number_format = NUM
    s1.cell(row=r, column=5, value=f'=IFERROR($C{r}/$D{r},"")').font = BLACK
    s1.cell(row=r, column=5).number_format = YEN
    s1.cell(row=r, column=6, value=(例[5] if ex else None)).font = BLUE
    s1.cell(row=r, column=7, value=(例[6] if ex else None)).font = BLUE
    s1.cell(row=r, column=8, value=(例[7] if ex else None)).font = BLUE
    s1.cell(row=r, column=9, value=f'=IF($A{r}="","",TEXT($A{r},"yyyy/mm"))').font = BLACK
    if r <= 4 + SHOWN:
        for col in range(1, 10):
            s1.cell(row=r, column=col).border = BOX
            if col in (1, 3, 4, 6, 7, 8):
                s1.cell(row=r, column=col).fill = FILLI
            s1.cell(row=r, column=col).alignment = Alignment(vertical="center")

last = 4 + DAYS
s1.cell(row=3, column=1, value="この表の合計").font = Font(name=F, size=10, bold=True)
s1.cell(row=3, column=3, value=f"=SUM($C$5:$C${last})").font = Font(name=F, size=10, bold=True)
s1.cell(row=3, column=3).number_format = YEN
s1.cell(row=3, column=4, value=f"=SUM($D$5:$D${last})").font = Font(name=F, size=10, bold=True)
s1.cell(row=3, column=4).number_format = NUM
s1.cell(row=3, column=5, value='=IFERROR($C$3/$D$3,"")').font = Font(name=F, size=10, bold=True)
s1.cell(row=3, column=5).number_format = YEN
s1.cell(row=3, column=6, value="←日付を入れた行だけが足されます").font = NOTE
for col in range(1, 6):
    s1.cell(row=3, column=col).border = BOX

s1.cell(row=last + 2, column=1,
        value="※ 客単価は 売上 ÷ 来客数。来客数が空のときは何も出ません。").font = NOTE
s1.cell(row=last + 3, column=1,
        value="※ この表は400行（13か月ぶん）まで数式が入っています。足りなくなったら最終行をコピーして貼り足してください。").font = NOTE
s1.freeze_panes = "A5"

# ============================================================
# シート② 月次集計
# ============================================================
s2 = wb.create_sheet("月次集計")
s2["A1"] = "売上管理表｜月次集計"; s2["A1"].font = TITLE
s2["A2"] = "青い字のセルに入力してください。ほかは日次入力シートから自動で集計されます。"
s2["A2"].font = NOTE
s2["A4"] = "集計を始める月"; s2["A4"].font = Font(name=F, size=10, bold=True)
s2["B4"] = datetime.date(2026, 10, 1)
s2["B4"].font = BLUE; s2["B4"].number_format = "yyyy/mm"; s2["B4"].fill = FILLI; s2["B4"].border = BOX
s2["C4"] = "←ここを変えると下の24か月がまとめて動きます"; s2["C4"].font = NOTE

cols2 = [("月", 10), ("売上合計", 14), ("来客数合計", 12), ("客単価平均", 12),
         ("前月比", 10), ("前年同月比", 12), ("目標", 14), ("達成率", 10)]
for i, (name, w) in enumerate(cols2, start=1):
    c = s2.cell(row=6, column=i, value=name)
    c.font = HEAD; c.fill = FILLH; c.alignment = Alignment(horizontal="center")
    s2.column_dimensions[get_column_letter(i)].width = w

for n in range(MONTHS):
    r = 7 + n
    s2.cell(row=r, column=1, value=f'=TEXT(EDATE($B$4,{n}),"yyyy/mm")').font = BLACK
    s2.cell(row=r, column=2, value=f'=SUMIF(日次入力!$I$5:$I$404,$A{r},日次入力!$C$5:$C$404)').font = BLACK
    s2.cell(row=r, column=2).number_format = YEN
    s2.cell(row=r, column=3, value=f'=SUMIF(日次入力!$I$5:$I$404,$A{r},日次入力!$D$5:$D$404)').font = BLACK
    s2.cell(row=r, column=3).number_format = NUM
    s2.cell(row=r, column=4, value=f'=IFERROR($B{r}/$C{r},"")').font = BLACK
    s2.cell(row=r, column=4).number_format = YEN
    if n == 0:
        s2.cell(row=r, column=5, value="").font = BLACK
    else:
        s2.cell(row=r, column=5, value=f'=IFERROR($B{r}/$B{r-1}-1,"")').font = BLACK
    s2.cell(row=r, column=5).number_format = PCT
    if n < 12:
        s2.cell(row=r, column=6, value="").font = BLACK
    else:
        s2.cell(row=r, column=6, value=f'=IFERROR($B{r}/$B{r-12}-1,"")').font = BLACK
    s2.cell(row=r, column=6).number_format = PCT
    s2.cell(row=r, column=7, value=None).font = BLUE
    s2.cell(row=r, column=7).number_format = YEN
    s2.cell(row=r, column=7).fill = FILLI
    s2.cell(row=r, column=8, value=f'=IFERROR($B{r}/$G{r},"")').font = BLACK
    s2.cell(row=r, column=8).number_format = PCT
    for col in range(1, 9):
        s2.cell(row=r, column=col).border = BOX

e = 6 + MONTHS
s2.cell(row=e + 2, column=1, value="※ 客単価平均は 売上合計 ÷ 来客数合計。日ごとの客単価を足して割った値とは少しずれます。").font = NOTE
s2.cell(row=e + 3, column=1, value="※ 前年同月比は13か月目から出ます。それまでは空欄のままで正常です。").font = NOTE
s2.cell(row=e + 4, column=1, value="※ 目標を空のままにすると、達成率も空欄になります。").font = NOTE
s2.freeze_panes = "A7"

# ============================================================
# シート③ グラフ
# ============================================================
s3 = wb.create_sheet("グラフ")
s3["A1"] = "売上管理表｜グラフ"; s3["A1"].font = TITLE
s3["A2"] = "月次集計シートの数字がそのまま出ます。触るところはありません。"; s3["A2"].font = NOTE

bar = BarChart(); bar.type = "col"; bar.title = "月別の売上"
bar.y_axis.title = "売上（円）"; bar.x_axis.title = "月"
bar.height = 9; bar.width = 20
bar.add_data(Reference(s2, min_col=2, min_row=6, max_row=6 + MONTHS), titles_from_data=True)
bar.set_categories(Reference(s2, min_col=1, min_row=7, max_row=6 + MONTHS))
s3.add_chart(bar, "A4")

line = LineChart(); line.title = "客単価の動き"
line.y_axis.title = "客単価（円）"; line.x_axis.title = "月"
line.height = 9; line.width = 20
line.add_data(Reference(s2, min_col=4, min_row=6, max_row=6 + MONTHS), titles_from_data=True)
line.set_categories(Reference(s2, min_col=1, min_row=7, max_row=6 + MONTHS))
s3.add_chart(line, "A24")

# ============================================================
# シート④ 商品・サービス別
# ============================================================
s4 = wb.create_sheet("商品・サービス別")
s4["A1"] = "売上管理表｜商品・サービス別"; s4["A1"].font = TITLE
s4["A2"] = "青い字のセルに入力してください。粗利と粗利率は自動で出ます。5行目は記入例です。"
s4["A2"].font = NOTE

cols4 = [("商品・サービス名", 24), ("売価", 12), ("原価", 12), ("粗利", 12),
         ("粗利率", 10), ("月の販売数", 12), ("売上", 14), ("粗利合計", 14)]
for i, (name, w) in enumerate(cols4, start=1):
    c = s4.cell(row=4, column=i, value=name)
    c.font = HEAD; c.fill = FILLH; c.alignment = Alignment(horizontal="center")
    s4.column_dimensions[get_column_letter(i)].width = w

ex4 = ["看板の定食", 1200, 540, None, None, 320, None, None]
for n in range(ITEMS):
    r = 5 + n
    ex = (n == 0)
    s4.cell(row=r, column=1, value=(ex4[0] if ex else None)).font = BLUE
    s4.cell(row=r, column=2, value=(ex4[1] if ex else None)).font = BLUE
    s4.cell(row=r, column=2).number_format = YEN
    s4.cell(row=r, column=3, value=(ex4[2] if ex else None)).font = BLUE
    s4.cell(row=r, column=3).number_format = YEN
    s4.cell(row=r, column=4, value=f'=IF($B{r}="","",$B{r}-$C{r})').font = BLACK
    s4.cell(row=r, column=4).number_format = YEN
    s4.cell(row=r, column=5, value=f'=IFERROR($D{r}/$B{r},"")').font = BLACK
    s4.cell(row=r, column=5).number_format = PCT
    s4.cell(row=r, column=6, value=(ex4[5] if ex else None)).font = BLUE
    s4.cell(row=r, column=6).number_format = NUM
    s4.cell(row=r, column=7, value=f'=IF($B{r}="","",$B{r}*$F{r})').font = BLACK
    s4.cell(row=r, column=7).number_format = YEN
    s4.cell(row=r, column=8, value=f'=IF($B{r}="","",$D{r}*$F{r})').font = BLACK
    s4.cell(row=r, column=8).number_format = YEN
    for col in range(1, 9):
        s4.cell(row=r, column=col).border = BOX
        if col in (1, 2, 3, 6):
            s4.cell(row=r, column=col).fill = FILLI

t4 = 5 + ITEMS
s4.cell(row=t4, column=1, value="合計").font = Font(name=F, size=10, bold=True)
s4.cell(row=t4, column=7, value=f"=SUM(G5:G{t4-1})").font = Font(name=F, size=10, bold=True)
s4.cell(row=t4, column=7).number_format = YEN
s4.cell(row=t4, column=8, value=f"=SUM(H5:H{t4-1})").font = Font(name=F, size=10, bold=True)
s4.cell(row=t4, column=8).number_format = YEN
s4.cell(row=t4, column=5, value=f'=IFERROR(H{t4}/G{t4},"")').font = Font(name=F, size=10, bold=True)
s4.cell(row=t4, column=5).number_format = PCT
for col in range(1, 9):
    s4.cell(row=t4, column=col).border = BOX

s4.cell(row=t4 + 2, column=1, value="※ 売上が多い商品と、粗利率が高い商品は一致しません。両方を見て売るものを決めてください。").font = NOTE
s4.cell(row=t4 + 3, column=1, value="※ 記入例は 売価1,200円・原価540円（粗利率55%）・月320食。上書きして使ってください。").font = NOTE
s4.freeze_panes = "A5"

out = "/home/user/gouter/assets/downloads/uriage-kanri-template.xlsx"
wb.save(out)
print("書き出した:", out)
