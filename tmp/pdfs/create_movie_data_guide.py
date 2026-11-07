from pathlib import Path

from reportlab.lib import colors
from reportlab.lib.enums import TA_CENTER, TA_LEFT
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import ParagraphStyle, getSampleStyleSheet
from reportlab.lib.units import cm
from reportlab.platypus import (
    KeepTogether,
    PageBreak,
    Paragraph,
    SimpleDocTemplate,
    Spacer,
    Table,
    TableStyle,
)


OUTPUT = Path("output/pdf/movie-data-beginner-guide.pdf")


def paragraph(text, style):
    return Paragraph(text, style)


def section(title, text, styles):
    return [
        Spacer(1, 10),
        Paragraph(title, styles["section"]),
        Spacer(1, 4),
        Paragraph(text, styles["body"]),
    ]


def build_pdf():
    OUTPUT.parent.mkdir(parents=True, exist_ok=True)
    document = SimpleDocTemplate(
        str(OUTPUT),
        pagesize=A4,
        rightMargin=1.8 * cm,
        leftMargin=1.8 * cm,
        topMargin=1.7 * cm,
        bottomMargin=1.7 * cm,
        title="Movie data guide for beginners",
        author="CineMatch",
    )

    sample = getSampleStyleSheet()
    styles = {
        "title": ParagraphStyle(
            "GuideTitle",
            parent=sample["Title"],
            fontName="Helvetica-Bold",
            fontSize=25,
            leading=30,
            textColor=colors.HexColor("#16213E"),
            alignment=TA_CENTER,
            spaceAfter=8,
        ),
        "subtitle": ParagraphStyle(
            "GuideSubtitle",
            parent=sample["BodyText"],
            fontName="Helvetica",
            fontSize=11,
            leading=16,
            textColor=colors.HexColor("#52616B"),
            alignment=TA_CENTER,
            spaceAfter=18,
        ),
        "section": ParagraphStyle(
            "GuideSection",
            parent=sample["Heading2"],
            fontName="Helvetica-Bold",
            fontSize=15,
            leading=19,
            textColor=colors.HexColor("#0F766E"),
            spaceBefore=4,
            spaceAfter=3,
        ),
        "body": ParagraphStyle(
            "GuideBody",
            parent=sample["BodyText"],
            fontName="Helvetica",
            fontSize=10.3,
            leading=15.2,
            textColor=colors.HexColor("#273444"),
        ),
        "small": ParagraphStyle(
            "GuideSmall",
            parent=sample["BodyText"],
            fontName="Helvetica",
            fontSize=9.2,
            leading=13,
            textColor=colors.HexColor("#273444"),
        ),
        "code": ParagraphStyle(
            "GuideCode",
            parent=sample["Code"],
            fontName="Courier",
            fontSize=8.5,
            leading=12.2,
            textColor=colors.HexColor("#102A43"),
            backColor=colors.HexColor("#EAF4F4"),
            borderColor=colors.HexColor("#B8E0D2"),
            borderWidth=0.6,
            borderPadding=8,
        ),
        "callout": ParagraphStyle(
            "GuideCallout",
            parent=sample["BodyText"],
            fontName="Helvetica-Bold",
            fontSize=10.3,
            leading=15,
            textColor=colors.HexColor("#1F2937"),
            backColor=colors.HexColor("#FFF7D6"),
            borderColor=colors.HexColor("#F5C451"),
            borderWidth=0.6,
            borderPadding=9,
        ),
    }

    story = [
        Paragraph("Your Movie Data Guide", styles["title"]),
        Paragraph(
            "A simple explanation of multiple genres, directors, cast members, and how to ask AI for help.",
            styles["subtitle"],
        ),
        Paragraph(
            "You do not need to memorize all the code. The important idea is: each movie can connect to many genres and many people.",
            styles["callout"],
        ),
    ]

    story += section(
        "1. The simple idea",
        "Before, one movie had only one text value for genre and one text value for director. Now your project can save many genres and many people for one movie. For example, Attack on Titan can have Action, Drama, and Fantasy. It can also have one director and several cast members.",
        styles,
    )

    data = [
        [paragraph("Table", styles["small"]), paragraph("What it stores", styles["small"]), paragraph("Easy example", styles["small"])],
        [paragraph("movies", styles["small"]), paragraph("Main movie or anime information", styles["small"]), paragraph("Attack on Titan", styles["small"])],
        [paragraph("genres", styles["small"]), paragraph("Each genre only once", styles["small"]), paragraph("Action, Drama, Fantasy", styles["small"])],
        [paragraph("genre_movie", styles["small"]), paragraph("Connects one movie to many genres", styles["small"]), paragraph("Attack on Titan -> Action", styles["small"])],
        [paragraph("people", styles["small"]), paragraph("Names of directors and cast", styles["small"]), paragraph("Tetsuro Araki, Yuki Kaji", styles["small"])],
        [paragraph("movie_person", styles["small"]), paragraph("Connects a movie to people and saves their role", styles["small"]), paragraph("Tetsuro Araki -> director", styles["small"])],
    ]
    table = Table(data, colWidths=[3.0 * cm, 7.1 * cm, 6.2 * cm], repeatRows=1)
    table.setStyle(TableStyle([
        ("BACKGROUND", (0, 0), (-1, 0), colors.HexColor("#0F766E")),
        ("TEXTCOLOR", (0, 0), (-1, 0), colors.white),
        ("FONTNAME", (0, 0), (-1, 0), "Helvetica-Bold"),
        ("VALIGN", (0, 0), (-1, -1), "TOP"),
        ("GRID", (0, 0), (-1, -1), 0.35, colors.HexColor("#C8D5D5")),
        ("BACKGROUND", (0, 1), (-1, -1), colors.HexColor("#F7FAFC")),
        ("ROWBACKGROUNDS", (0, 1), (-1, -1), [colors.HexColor("#F7FAFC"), colors.HexColor("#EEF6F6")]),
        ("LEFTPADDING", (0, 0), (-1, -1), 7),
        ("RIGHTPADDING", (0, 0), (-1, -1), 7),
        ("TOPPADDING", (0, 0), (-1, -1), 7),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 7),
    ]))
    story += [Spacer(1, 9), table]

    story.append(PageBreak())
    story += section(
        "2. Why the role moved to movie_person",
        "A person can be cast in one series and a director in another. So the role is saved on the movie-to-person connection, not only on the person record.",
        styles,
    )
    story += [Spacer(1, 10), Paragraph("Movie -> Person -> Role", styles["code"]), Spacer(1, 5), Paragraph("Attack on Titan -> Tetsuro Araki -> director<br/>Attack on Titan -> Yuki Kaji -> cast", styles["code"])]

    story += section(
        "3. How to use the Create Movie form",
        "Go to Admin Dashboard -> Create Movie. Fill in the title, rating, thumbnail, and description. Then select one or more genres. On a Mac, hold Command while selecting more than one genre. On Windows, hold Ctrl.",
        styles,
    )
    steps = [
        "1. Choose genres: Action, Drama, Fantasy.",
        "2. Write directors: one name on each line.",
        "3. Write cast members: one name on each line.",
        "4. Upload a JPG, PNG, or WEBP thumbnail.",
        "5. Click Create movie.",
    ]
    story += [Paragraph("<br/>".join(steps), styles["body"])]
    story += [Spacer(1, 9), Paragraph("Example form values", styles["section"]), Paragraph("Genres: Action, Drama, Fantasy<br/>Directors:<br/>Tetsuro Araki<br/><br/>Cast members:<br/>Yuki Kaji<br/>Yui Ishikawa<br/>Marina Inoue", styles["code"])]

    story += section(
        "4. What the important code files do",
        "Movie model: tells Laravel that a movie has many genres and many people.<br/><br/>Genre model: tells Laravel that a genre can belong to many movies.<br/><br/>Admin Movie Controller: reads the form, validates it, creates the movie, then saves genre and credit connections.<br/><br/>Create Movie Blade file: shows the fields that you see in the browser.",
        styles,
    )
    story += [Paragraph("The old genre and director text columns are still kept so your older movies continue to work. New movies also use the better connection tables.", styles["callout"])]

    story.append(PageBreak())
    story += section(
        "5. How to ask AI when you are confused",
        "You can upload this PDF, or copy a small code section, into an AI chat. Ask one clear question at a time. Include the file name and any error message.",
        styles,
    )
    prompts = [
        "Explain this Laravel code like I am a beginner. Use simple English and show one example: [paste code here]",
        "What is the difference between people and movie_person in my movie website?",
        "Why do I use genre_movie instead of putting many genres in one movies column?",
        "I see this Laravel error: [paste the full error]. Tell me which file to check first. Do not change code yet.",
        "Show me how this form data moves from create.blade.php to Admin MovieController, step by step.",
    ]
    for prompt in prompts:
        story += [Spacer(1, 6), Paragraph(prompt, styles["code"])]

    story += section(
        "6. A safe way to learn",
        "First ask AI to explain. Next, ask it to show only the file that needs changing. Finally, make one small change and test it. If you get an error, copy the whole error message, not only the last line.",
        styles,
    )

    def page_number(canvas, doc):
        canvas.saveState()
        canvas.setFont("Helvetica", 8.5)
        canvas.setFillColor(colors.HexColor("#64748B"))
        canvas.drawRightString(A4[0] - 1.8 * cm, 1.0 * cm, f"CineMatch beginner guide - Page {doc.page}")
        canvas.restoreState()

    document.build(story, onFirstPage=page_number, onLaterPages=page_number)


if __name__ == "__main__":
    build_pdf()
