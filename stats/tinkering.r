library("pacman")

p_load(
    "tidyverse",
    "readxl",
    "ggplot2",
    "ggpubr"
)

# Load the data
df_supporters <- read.csv("stats/data/supporters-2024-05-27-06-53-06.csv")

## Filter df_supporters where stage=pledge and signtureCount is not na
df_supporters_pledge <- df_supporters %>%
    filter(
        stage == "pledge",
        !is.na(signatureCount)
    )

## Add datetime column converting created_at to date
df_supporters_pledge <- df_supporters_pledge %>%
    mutate(datetime = as.POSIXct(created_at, format = "%Y-%m-%dT%H:%M:%S.000000Z"))

## Calculate the number of hours since the first pledge
hours_since_first_pledge <- df_supporters_pledge %>%
    summarize(
        hours_since_first_pledge = round(as.numeric(difftime(max(datetime), min(datetime), units = "hours")))
    )

## Loop through the number of hours since the first pledge and calculate the number of rows for each hour, adding to a dataframe
df_hours_since_first_pledge <- data.frame()
for (i in 0:hours_since_first_pledge$hours_since_first_pledge) {
    time_cutoff <- min(df_supporters_pledge$datetime) + hours(i)
    df_hours_since_first_pledge <- df_hours_since_first_pledge %>%
        bind_rows(
            df_supporters_pledge %>%
                filter(
                    datetime <= time_cutoff,
                    datetime > time_cutoff - hours(1)
                ) %>%
                summarize(
                    time = time_cutoff,
                    num_supporters = n(),
                    num_signatures = sum(as.numeric(signatureCount)),
                )
        )
}

## Add columns summing the number of supporters and signatures for each row before the current row
df_hours_since_first_pledge <- df_hours_since_first_pledge %>%
    mutate(
        total_supporters = cumsum(num_supporters),
        total_signatures = cumsum(num_signatures)
    )


## Plot the number of supporters and signatures over time
ggplot(df_hours_since_first_pledge, aes(x = time)) +
    geom_line(aes(y = total_supporters, color = "Supporters")) +
    geom_line(aes(y = total_signatures, color = "Signatures")) +
    scale_color_manual(values = c("Supporters" = "blue", "Signatures" = "red")) +
    labs(
        title = "Number of Supporters and Signatures Over Time",
        x = "Time",
        y = "Count"
    ) +
    theme_minimal()

## Plot the number of supporters and signatures over time
ggplot(df_hours_since_first_pledge, aes(x = time)) +
    geom_line(aes(y = total_supporters, color = "Supporters")) +
    geom_line(aes(y = total_signatures, color = "Signatures")) +
    scale_color_manual(values = c("Supporters" = "blue", "Signatures" = "red")) +
    labs(
        title = "Number of Supporters and Signatures Over Time",
        x = "Time",
        y = "Count"
    ) +
    ## Add a horizontal line at 2'000 supporters
    geom_hline(yintercept = 2000, linetype = "dashed", color = "blue") +
    ## Add a horizontal line at 20'000 signatures
    geom_hline(yintercept = 20000, linetype = "dashed", color = "red") +
    theme_minimal()

## Plot the number of supporters and signatures over time
ggplot(df_hours_since_first_pledge, aes(x = time)) +
    geom_line(aes(y = total_supporters, color = "Supporters")) +
    geom_line(aes(y = total_signatures, color = "Signatures")) +
    scale_color_manual(values = c("Supporters" = "blue", "Signatures" = "red")) +
    labs(
        title = "Number of Supporters and Signatures Over Time",
        x = "Time",
        y = "Count"
    ) +
    theme_minimal()


## Find vector of values for campaign
campaigns <- df_supporters_pledge %>%
    select(campaign) %>%
    distinct() %>%
    pull()

## Create frequency table of campaigns
df_campaigns <- df_supporters_pledge %>%
    group_by(campaign) %>%
    summarize(
        num_supporters = n(),
        num_signatures = sum(as.numeric(signatureCount))
    ) %>%
    arrange(desc(num_supporters))

## Calculate the number of signatures per supporter for each campaign
df_campaigns <- df_campaigns %>%
    mutate(
        signatures_per_supporter = num_signatures / num_supporters
    )

## Calculate conversion rateb of campaigns to supporters
# Number of contacts avi-pledge-nl=3879+23+301
# Number of contacts gsoa-pledge-nl=16187+1774
# Number of contacts korrektur-pledge-nl=34334+6479
# Number of contacts f35-pledge-nl=4822+19745

df_campaigns <- df_campaigns %>%
    mutate(
        conversion_rate = case_when(
            campaign == "avi-pledge-nl" ~ num_supporters / 3879 * 100,
            campaign == "gsoa-pledge-nl" ~ num_supporters / 16187 * 100,
            campaign == "korrektur-pledge-nl" ~ num_supporters / 34334 * 100,
            campaign == "f35-pledge-nl" ~ num_supporters / 4822 * 100,
            TRUE ~ 0
        )
    )

## Plot the number of supporters and signatures for each campaign as a cake chart
cake_campaign_supp <- ggplot(df_campaigns, aes(x = "", y = num_supporters, fill = campaign)) +
    geom_bar(stat = "identity", width = 1) +
    coord_polar("y", start = 0) +
    labs(
        title = "Number of Supporters by Campaign",
        x = NULL,
        y = NULL
    ) +
    ## add the number of supporters as labels
    geom_text(aes(label = num_supporters), position = position_stack(vjust = 0.5)) +
    theme_void() +
    theme(legend.position = "bottom")

cake_campaign_sign <- ggplot(df_campaigns, aes(x = "", y = num_signatures, fill = campaign)) +
    geom_bar(stat = "identity", width = 1) +
    coord_polar("y", start = 0) +
    labs(
        title = "Number of Signatures by Campaign",
        x = NULL,
        y = NULL
    ) +
    ## add the number of signatures as labels
    geom_text(aes(label = num_signatures), position = position_stack(vjust = 0.5)) +
    theme_void() +
    theme(legend.position = "bottom")

## Plot the number of signatures per supporter for each campaign as a bar chart
bar_campaign_perperson <- ggplot(df_campaigns, aes(x = reorder(campaign, +signatures_per_supporter), y = signatures_per_supporter, fill = campaign)) +
    geom_bar(stat = "identity") +
    labs(
        title = "Number of Signatures per Supporter by Campaign",
        x = "Campaign",
        y = "Signatures per Supporter"
    ) +
    theme_minimal() +
    theme(axis.text.x = element_text(angle = 45, hjust = 1))

bar_campaign_conversion <- ggplot(df_campaigns, aes(x = reorder(campaign, +conversion_rate), y = conversion_rate, fill = campaign)) +
    geom_bar(stat = "identity") +
    labs(
        title = "Conversion Rate by Campaign",
        x = "Campaign",
        y = "Conversion Rate (%)"
    ) +
    theme_minimal() +
    theme(axis.text.x = element_text(angle = 45, hjust = 1))

ggarrange(cake_campaign_supp, cake_campaign_sign, bar_campaign_perperson, bar_campaign_conversion, ncol = 2, nrow = 2)



## Find vector of values for locale
locales <- df_supporters_pledge %>%
    select(locale) %>%
    distinct() %>%
    pull()

## Create frequency table of locales

df_locales <- df_supporters_pledge %>%
    group_by(locale) %>%
    summarize(
        num_supporters = n(),
        num_signatures = sum(as.numeric(signatureCount))
    ) %>%
    arrange(desc(num_supporters))

## Calculate the number of signatures per supporter for each locale
df_locales <- df_locales %>%
    mutate(
        signatures_per_supporter = num_signatures / num_supporters
    )

## Plot the number of supporters and signatures for each locale as a cake chart
cake_locale_supp <- ggplot(df_locales, aes(x = "", y = num_supporters, fill = locale)) +
    geom_bar(stat = "identity", width = 1) +
    coord_polar("y", start = 0) +
    labs(
        title = "Number of Supporters by Language",
        x = NULL,
        y = NULL
    ) +
    ## add the number of supporters as labels
    geom_text(aes(label = num_supporters), position = position_stack(vjust = 0.5)) +
    theme_void() +
    theme(legend.position = "bottom")

cake_locale_sign <- ggplot(df_locales, aes(x = "", y = num_signatures, fill = locale)) +
    geom_bar(stat = "identity", width = 1) +
    coord_polar("y", start = 0) +
    labs(
        title = "Number of Signatures by Language",
        x = NULL,
        y = NULL
    ) +
    ## add the number of signatures as labels
    geom_text(aes(label = num_signatures), position = position_stack(vjust = 0.5)) +
    theme_void() +
    theme(legend.position = "bottom")

## Plot the number of signatures per supporter for each locale as a bar chart
bar_locale_perperson <- ggplot(df_locales, aes(x = reorder(locale, +signatures_per_supporter), y = signatures_per_supporter, fill = locale)) +
    geom_bar(stat = "identity") +
    labs(
        title = "Number of Signatures per Supporter by Language",
        x = "Locale",
        y = "Signatures per Supporter"
    ) +
    theme_minimal() +
    theme(axis.text.x = element_text(angle = 45, hjust = 1))

ggarrange(cake_locale_supp, cake_locale_sign, bar_locale_perperson, ncol = 2, nrow = 2)


## Display supporters with locale=it
df_supporters_pledge %>%
    ## Arrange by signatureCount desc
    arrange(desc(as.numeric(signatureCount))) %>%
    head(5) %>%
    view()

view(df_campaigns)
