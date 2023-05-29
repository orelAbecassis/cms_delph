import openai
openai.api_key = "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"

# récupérer le dernier prompt stocké
last_prompt = "Le dernier prompt que j'ai écrit est ..."

# envoyer une requête à l'API OpenAI
response = openai.Completion.create(
    engine="davinci",
    prompt=last_prompt,
    max_tokens=100,
    n=1,
    stop=None,
    temperature=0.5
)

# récupérer le texte généré à partir de la réponse
generated_text = response.choices[0].text

# utiliser le texte généré dans votre application
print(generated_text)
